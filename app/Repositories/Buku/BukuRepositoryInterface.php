<?php

namespace App\Repositories\Buku;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface BukuRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
