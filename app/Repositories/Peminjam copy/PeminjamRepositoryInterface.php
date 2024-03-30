<?php

namespace App\Repositories\Peminjam;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface PeminjamRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
