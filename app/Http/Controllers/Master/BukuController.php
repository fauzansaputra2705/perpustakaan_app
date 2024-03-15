<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Models\Example;
use App\Repositories\Buku\BukuRepositoryInterface;
use App\Repositories\Crud\CrudRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    /**
     * @var BukuRepositoryInterface
     */
    protected $buku;

    public function __construct(BukuRepositoryInterface $buku)
    {
        $this->buku = $buku;

        $this->middleware('permission:view data buku', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:create data buku', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit data buku', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete data buku', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Buku/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->buku->queryWhere([], [
            'bukus.*',
            'rak_bukus.nama as nama_rak',
            'rak_bukus.lokasi as lokasi_rak',
            'kategoris.nama as nama_kategori',
        ]);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';

                if (Auth::user()?->can('edit data buku')) {
                    $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                    <i class="ti ti-edit fs-5"></i>
                    </a>';
                }

                if (Auth::user()?->can('delete data buku')) {
                    $btn .= '<a class="text-dark delete ms-2" data-id="' . $data->id . '">
                            <i class="ti ti-trash fs-5"></i>
                            </a>';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param  BukuRequest  $request
     * @return mixed
     */
    public function store(BukuRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();
            if ($request->hasFile('cover')) {
                $namaFolder = 'cover_book';
                $pathFile = uploadFile(
                    $namaFolder,
                    $request->cover,
                    'cover-book-' . $request->slug
                );
                $attributes['cover'] = $pathFile;
            }

            $this->buku->create($attributes);

            DB::commit();
            return to_route('master.buku.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.buku.index')->withErrors([
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
        $data = $this->buku->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param BukuRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(BukuRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            /** @var Buku $buku */
            $buku = $this->buku->find($id);

            $attributes = $request->all();
            if ($request->hasFile('cover')) {
                deleteFile($buku->cover);
                $namaFolder = 'cover_book';
                $pathFile = uploadFile(
                    $namaFolder,
                    $request->cover,
                    'cover-book-' . $request->slug
                );
                $attributes['cover'] = $pathFile;
            }
            $buku->update($attributes);

            DB::commit();
            return to_route('master.buku.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.buku.index')->withErrors([
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
            /** @var Buku|null */
            $buku = $this->buku->find($id);

            if ($buku) {
                deleteFile($buku->cover);
                $buku->delete();
            }

            DB::commit();
            return to_route('master.buku.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.buku.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
