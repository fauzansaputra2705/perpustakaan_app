<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeminjamRequest;
use App\Models\Buku;
use App\Models\LogPeminjam;
use App\Models\Peminjam;
use App\Repositories\Buku\BukuRepositoryInterface;
use App\Repositories\Peminjam\PeminjamRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PeminjamanController extends Controller
{
    /**
     * @var PeminjamRepositoryInterface
     */
    protected $peminjam;

    /**
     * @var BukuRepositoryInterface
     */
    protected $buku;

    public function __construct(
        PeminjamRepositoryInterface $peminjam,
        BukuRepositoryInterface $buku,
    ) {
        $this->peminjam = $peminjam;
        $this->buku = $buku;
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Peminjaman/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->peminjam->queryWhere([
            ['peminjams.status', '=', '"dipinjam"']
        ], [
            'peminjams.*',
            'anggotas.kode_anggota',
            'anggotas.nama as nama_anggota',
            'anggotas.jenis_kelamin',
            'kelas.nama as nama_kelas',
            'bukus.title',
            'bukus.isbn'
        ])
            ->orderBy('created_at', 'DESC');
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->editColumn('lama_pinjam', function ($data) {
                return $data->lama_pinjam . ' Hari <br>' .
                    'tanggal kembali : ' . Carbon::parse($data->tanggal_pinjam)->addDay($data->lama_pinjam);
            })
            ->addColumn('action', function ($data) {
                $btn = '<div class="action-btn">';


                // $btn .= '<a class="text-info edit" data-id="' . $data->id . '">
                //     <i class="ti ti-edit fs-5"></i>
                //     </a>';

                // $btn .= '<a class="text-dark delete ms-2" data-id="' . $data->id . '">
                //             <i class="ti ti-trash fs-5"></i>
                //             </a>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['lama_pinjam'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param  PeminjamRequest  $request
     * @return mixed
     */
    public function store(PeminjamRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Peminjam $peminjam */
            $peminjam = $this->peminjam->updateOrCreate([
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id
            ], $request->all());

            /** @var ?Buku $buku */
            $buku = $this->buku->find($peminjam->buku_id);

            if ($peminjam->anggota_id != $request->anggota_id && $peminjam->buku_id != $request->buku_id) {
                if (isset($buku)) {
                    $buku->update([
                        'jumlah_stok' => $buku->jumlah_stok - 1
                    ]);
                }
            }

            $logPeminjam = LogPeminjam::create([
                'peminjam_id' => $peminjam->id,
                'petugas_id' => Auth::user()->petugas->id,
                'status_peminjam' => $peminjam->status,
                'keterangan_peminjam' => $peminjam->keterangan,
                'kondisi_buku' => $peminjam->kondisi_buku_minjam,
            ]);

            DB::commit();
            return to_route('petugas.peminjam.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('petugas.peminjam.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
