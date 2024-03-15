<?php

namespace App\Http\Controllers;

use App\Models\Example;
use App\Models\Kategori;
use App\Models\RakBuku;
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

    public function __construct(CrudRepositoryInterface $crud)
    {
        $this->example = new $crud;
        $this->example->setModel(new Example());

        $this->kategori = new $crud;
        $this->kategori->setModel(new Kategori());

        $this->rakBuku = new $crud;
        $this->rakBuku->setModel(new RakBuku());
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
}
