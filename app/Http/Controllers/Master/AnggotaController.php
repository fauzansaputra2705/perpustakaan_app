<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnggotaRequest;
use App\Http\Traits\HelperTrait;
use App\Models\Anggota;
use App\Models\User;
use App\Repositories\Anggota\AnggotaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnggotaController extends Controller
{

    use HelperTrait;

    /**
     * @var AnggotaRepositoryInterface
     */
    protected $anggota;

    public function __construct(AnggotaRepositoryInterface $crud)
    {
        $this->anggota = $crud;
        $this->anggota->setModel(new Anggota());

        $this->middleware('permission:view data anggota', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:create data anggota', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit data anggota', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete data anggota', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Anggota/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->anggota->queryWhere([], [
            'anggotas.*',
            'kelas.nama as nama_kelas'
        ]);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';

                if (Auth::user()?->can('edit data anggota')) {
                    $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                    <i class="ti ti-edit fs-5"></i>
                    </a>';
                }

                if (Auth::user()?->can('delete data anggota')) {
                    $btn .= '<a class="text-dark delete ms-2" data-id="' . $data->id . '">
                            <i class="ti ti-trash fs-5"></i>
                            </a>';
                }

                $btn .= '<a href="' . route('download_kartu_anggota', ['anggotaId' => $this->stringToCrypt($data->id)]) . '"
                class="text-dark ms-2"
                target="_blank"
                >
                                <i class="ti ti-printer fs-5"></i>
                                </a>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns([])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param  AnggotaRequest  $request
     * @return mixed
     */
    public function store(AnggotaRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();
            if ($request->hasFile('foto')) {
                $namaFolder = 'foto_anggota';
                $pathFile = uploadFile(
                    $namaFolder,
                    $request->foto,
                    'foto_'
                );
                $attributes['foto'] = $pathFile;
            }

            $user = User::create([
                'username' => '',
                'name' => $request->nama,
                'email' => $request->email,
                'password' =>  bcrypt('000000'),
                'path_image' => $attributes['foto'],
                'role' => 'anggota'
            ]);

            $user->syncRoles('anggota');

            $attributes['user_id'] = $user->id;
            $this->anggota->create($attributes);

            DB::commit();
            return to_route('master.anggota.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.anggota.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return mixed
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param integer $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = $this->anggota->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param AnggotaRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(AnggotaRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            /** @var Anggota $anggota */
            $anggota =  $this->anggota->find($id);

            $attributes = $request->all();
            if ($request->hasFile('foto')) {
                deleteFile($anggota->foto);
                $namaFolder = 'foto_anggota';
                $pathFile = uploadFile(
                    $namaFolder,
                    $request->foto,
                    'foto_'
                );
                $attributes['foto'] = $pathFile;
            }

            // $user = User::create([
            //     'username' => '',
            //     'name' => $request->nama,
            //     'email' => $request->email,
            //     'password' =>  bcrypt('000000'),
            //     'path_image' => $attributes['foto'],
            //     'role' => 'anggota'
            // ]);

            // $user->syncRoles('anggota');

            // $attributes['user_id'] = $user->id;

            $anggota->update($attributes);

            DB::commit();
            return to_route('master.anggota.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.anggota.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param integer $id
     * @return mixed
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** @var Anggota|null */
            $anggota = $this->anggota->find($id);

            if ($anggota) {
                deleteFile($anggota->foto);

                /** @var User|null */
                $user = User::find($anggota->user_id);
                if ($user) {
                    $user->delete();
                }

                $anggota->delete();
            }

            DB::commit();
            return to_route('master.anggota.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.anggota.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }


    /**
     * kartu Anggota
     *
     * @param   string  $anggotaId
     *
     * @return mixed
     */
    public function kartuAnggota($anggotaId = null)
    {
        $anggotaId = $this->cryptToString($anggotaId);

        /** @var ?Anggota $anggota */
        $anggota = $this->anggota->find($anggotaId);

        if (!isset($anggota)) {
            return back()->withErrors([
                'message' => 'Anggota tidak ada',
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }

        return $this->generateKartuAnggota($anggota);
    }
}
