<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\PetugasRequest;
use App\Models\Petugas;
use App\Models\User;
use App\Repositories\Petugas\PetugasRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{
    /**
     * @var PetugasRepositoryInterface
     */
    protected $petugas;

    public function __construct(PetugasRepositoryInterface $crud)
    {
        $this->petugas = $crud;
        $this->petugas->setModel(new Petugas());

        $this->middleware('permission:view data petugas', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:create data petugas', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit data petugas', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete data petugas', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Petugas/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->petugas->queryWhere([], []);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';

                if (Auth::user()?->can('edit data petugas')) {
                    $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                    <i class="ti ti-edit fs-5"></i>
                    </a>';
                }

                if (Auth::user()?->can('delete data petugas')) {
                    $btn .= '<a class="text-dark delete ms-2" data-id="' . $data->id . '">
                            <i class="ti ti-trash fs-5"></i>
                            </a>';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns([])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param  PetugasRequest  $request
     * @return mixed
     */
    public function store(PetugasRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();
            if ($request->hasFile('foto')) {
                $namaFolder = 'foto';
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
                'role' => 'petugas'
            ]);

            $user->syncRoles('petugas');

            $attributes['user_id'] = $user->id;
            $this->petugas->create($attributes);

            DB::commit();
            return to_route('master.petugas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.petugas.index')->withErrors([
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
        $data = $this->petugas->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param PetugasRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(PetugasRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            /** @var Petugas $petugas */
            $petugas =  $this->petugas->find($id);

            $attributes = $request->all();
            if ($request->hasFile('foto')) {
                deleteFile($petugas->foto);
                $namaFolder = 'foto';
                $pathFile = uploadFile(
                    $namaFolder,
                    $request->cover,
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
                'role' => 'petugas'
            ]);

            $user->syncRoles('petugas');

            $attributes['user_id'] = $user->id;

            $petugas->update($attributes);

            DB::commit();
            return to_route('master.petugas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.petugas.index')->withErrors([
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
            /** @var Petugas|null */
            $petugas = $this->petugas->find($id);

            if ($petugas) {
                deleteFile($petugas->foto);

                /** @var User|null */
                $user = User::find($petugas->user_id);
                if ($user) {
                    $user->delete();
                }

                $petugas->delete();
            }

            DB::commit();
            return to_route('master.petugas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.petugas.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
