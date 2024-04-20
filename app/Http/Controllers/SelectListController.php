<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Example;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Peminjam;
use App\Models\RakBuku;
use App\Repositories\Anggota\AnggotaRepositoryInterface;
use App\Repositories\Buku\BukuRepositoryInterface;
use App\Repositories\Crud\CrudRepositoryInterface;

class SelectListController extends Controller
{
    public const DATA_TIDAK_DITEMUKAN = 'Data tidak ditemukan';
    /**
     * @var CrudRepositoryInterface
     */
    protected $example;

    /**
     * @var CrudRepositoryInterface
     */
    protected $kategori;

    /**
     * @var CrudRepositoryInterface
     */
    protected $rakBuku;

    /**
     * @var CrudRepositoryInterface
     */
    protected $kelas;

    /**
     * @var AnggotaRepositoryInterface
     */
    protected $anggota;

    /**
     * @var BukuRepositoryInterface
     */
    protected $buku;

    public function __construct(
        CrudRepositoryInterface $crud,
        AnggotaRepositoryInterface $anggota,
        BukuRepositoryInterface $buku,
    ) {
        $this->example = new $crud;
        $this->example->setModel(new Example());

        $this->kategori = new $crud;
        $this->kategori->setModel(new Kategori());

        $this->rakBuku = new $crud;
        $this->rakBuku->setModel(new RakBuku());

        $this->kelas = new $crud;
        $this->kelas->setModel(new Kelas());

        $this->anggota = $anggota;

        $this->buku = $buku;
    }

    /**
     * get list example for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getExample()
    {
        $data = $this->example->queryWhere(
            [],
            []
        );

        $result = $data->pluck('nama', 'id');

        // @phpstan-ignore-next-line
        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list kategori for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListKategori()
    {
        $data = $this->kategori->queryWhere(
            [],
            []
        );

        $result = $data->pluck('nama', 'id');

        // @phpstan-ignore-next-line
        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list rak buku for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListRakBuku()
    {
        $data = $this->rakBuku->queryWhere(
            [],
            []
        );

        $result = $data->pluck('nama', 'id');

        // @phpstan-ignore-next-line
        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list kelas for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListKelas()
    {
        $data = $this->kelas->queryWhere(
            [],
            []
        );

        $result = $data->pluck('nama', 'id');

        // @phpstan-ignore-next-line
        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list anggota for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListAnggota()
    {
        $data = $this->anggota->queryWhere(
            [],
            []
        );

        $result = [];

        /** @var Anggota[] $p */
        $p = $data->get();

        foreach ($p as $value) {
            $result[$value->id] = "$value->nama ($value->kode_anggota)";
        }

        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list buku for select option
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListBuku()
    {
        $data = $this->buku->queryWhere(
            [
                ['jumlah_stok', '<>', 0]
            ],
            []
        );

        $result = [];

        /** @var Buku[] $p */
        $p = $data->get();

        foreach ($p as $value) {
            $result[$value->id] = "$value->title ($value->isbn)";
        }

        if (!$result) {
            return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        }
        return $this->ok($result);
    }

    /**
     * get list buku peminjam for select option
     *
     * @param int $anggotaId
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getListBukuPeminjam($anggotaId = null)
    {
        $data = Peminjam::join('bukus', 'bukus.id', '=', 'peminjams.buku_id')
            ->where('peminjams.anggota_id', $anggotaId)
            ->select('bukus.*');

        $result = [];

        /** @var Peminjam[] $p */
        $p = $data->get();

        foreach ($p as $value) {
            $result[$value->id] = "$value->title ($value->isbn)";
        }

        // if (!$result) {
        //     return $this->oops(self::DATA_TIDAK_DITEMUKAN);
        // }
        return $this->ok($result);
    }
}
