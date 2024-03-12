<?php

namespace App\Repositories\Example;

use App\Models\Example;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExampleRepository extends BaseRepository implements ExampleRepositoryInterface
{
    public function model()
    {
        return new Example;
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
