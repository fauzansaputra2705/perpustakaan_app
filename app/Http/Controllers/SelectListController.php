<?php

namespace App\Http\Controllers;

use App\Models\Example;
use App\Repositories\Crud\CrudRepositoryInterface;

class SelectListController extends Controller
{
    public const DATA_TIDAK_DITEMUKAN = 'Data tidak ditemukan';
    /**
     * @var CrudRepositoryInterface
     */
    protected $example;

    public function __construct(CrudRepositoryInterface $crud)
    {
        $this->example = new $crud;
        $this->example->setModel(new Example());
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
}
