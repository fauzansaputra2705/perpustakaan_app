<?php

namespace App\Repositories\Crud;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface CrudRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
