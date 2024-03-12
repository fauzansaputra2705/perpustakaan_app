<?php

namespace App\Repositories\Example;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface ExampleRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
