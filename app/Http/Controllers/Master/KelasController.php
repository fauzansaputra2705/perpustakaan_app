<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelasRequest;
use App\Models\Kelas;
use App\Repositories\Crud\CrudRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    /**
     * @var CrudRepositoryInterface
     */
    protected $kelas;

    public function __construct(CrudRepositoryInterface $crud)
    {
        $this->kelas = $crud;
        $this->kelas->setModel(new Kelas());

        $this->middleware('permission:view data kelas', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:create data kelas', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit data kelas', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete data kelas', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Kelas/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->kelas->queryWhere([], []);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';

                if (Auth::user()?->can('edit data kelas')) {
                    $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                    <i class="ti ti-edit fs-5"></i>
                    </a>';
                }

                if (Auth::user()?->can('delete data kelas')) {
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
     * @param  KelasRequest  $request
     * @return mixed
     */
    public function store(KelasRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->kelas->create($request->all());

            DB::commit();
            return to_route('master.kelas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kelas.index')->withErrors([
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
        $data = $this->kelas->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param KelasRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(KelasRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->kelas->update($request->all(), $id);

            DB::commit();
            return to_route('master.kelas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kelas.index')->withErrors([
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
            $this->kelas->delete($id);

            DB::commit();
            return to_route('master.kelas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kelas.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
