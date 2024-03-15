<?php

namespace App\Repositories\Petugas;

use App\Models\Petugas;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PetugasRepository extends BaseRepository implements PetugasRepositoryInterface
{
    public function model()
    {
        return new Petugas;
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
            ->select($selects)
            ->join(
                'users',
                'users.id',
                '=',
                'petugas.user_id'
            );

        return $this->whenWhere($attr, $d);
    }
}
