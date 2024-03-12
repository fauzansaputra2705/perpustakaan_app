<?php

namespace App\Repositories\Crud;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CrudRepository extends BaseRepository implements CrudRepositoryInterface
{
    public function model()
    {
        return new User;
    }

    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder
    {
        $selects = '';
        if (count($select) > 0) {
            $selects = $select;
        } else {
            $selects = $this->getModel()->getTable() . '.*';
        }

        $d = $this->getModel()
            ->query()
            ->select($selects);

        return $this->whenWhere($attr, $d);
    }
}
