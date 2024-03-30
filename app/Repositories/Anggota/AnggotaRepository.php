<?php

namespace App\Repositories\Anggota;

use App\Models\Anggota;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AnggotaRepository extends BaseRepository implements AnggotaRepositoryInterface
{
    public function model()
    {
        return new Anggota;
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
                'anggotas.user_id'
            )
            ->join(
                'kelas',
                'kelas.id',
                '=',
                'anggotas.kelas_id'
            );

        return $this->whenWhere($attr, $d);
    }
}
