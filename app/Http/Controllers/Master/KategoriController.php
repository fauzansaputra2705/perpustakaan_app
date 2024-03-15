<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use App\Repositories\Crud\CrudRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    /**
     * @var CrudRepositoryInterface
     */
    protected $kategori;

    public function __construct(CrudRepositoryInterface $crud)
    {
        $this->kategori = $crud;
        $this->kategori->setModel(new Kategori());

        $this->middleware('permission:view data kategori', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:create data kategori', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit data kategori', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete data kategori', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Kategori/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->kategori->queryWhere([], []);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';

                if (Auth::user()?->can('edit data kategori')) {
                    $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                    <i class="ti ti-edit fs-5"></i>
                    </a>';
                }

                if (Auth::user()?->can('delete data kategori')) {
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
     * @param  KategoriRequest  $request
     * @return mixed
     */
    public function store(KategoriRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->kategori->create($request->all());

            DB::commit();
            return to_route('master.kategori.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kategori.index')->withErrors([
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
        $data = $this->kategori->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param KategoriRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(KategoriRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->kategori->update($request->all(), $id);

            DB::commit();
            return to_route('master.kategori.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kategori.index')->withErrors([
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
            $this->kategori->delete($id);

            DB::commit();
            return to_route('master.kategori.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.kategori.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
