<?php

namespace App\Repositories\Buku;

use App\Models\Buku;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BukuRepository extends BaseRepository implements BukuRepositoryInterface
{
    public function model()
    {
        return new Buku;
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
