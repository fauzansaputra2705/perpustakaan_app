<?php

namespace App\Repositories\Anggota;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface AnggotaRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
