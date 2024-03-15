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
            ->select($selects)
            ->join(
                'kategoris',
                'kategoris.id',
                '=',
                'bukus.kategori_id'
            )
            ->join(
                'rak_bukus',
                'rak_bukus.id',
                '=',
                'bukus.rak_buku_id'
            );

        return $this->whenWhere($attr, $d);
    }
}
