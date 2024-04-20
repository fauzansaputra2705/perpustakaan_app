<?php

namespace App\Repositories\Peminjam;

use App\Models\Peminjam;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PeminjamRepository extends BaseRepository implements PeminjamRepositoryInterface
{
    public function model()
    {
        return new Peminjam;
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
            ->leftJoin('anggotas', function ($q) {
                $q->on('anggotas.id', '=', 'peminjams.anggota_id')
                    ->leftjoin(
                        'users',
                        'users.id',
                        '=',
                        'anggotas.user_id'
                    )
                    ->leftjoin(
                        'kelas',
                        'kelas.id',
                        '=',
                        'anggotas.kelas_id'
                    )
                    ->select(
                        'anggotas.*',
                        'kelas.nama',
                        'kelas.tingkat',
                        'users.username'
                    );
            })
            ->leftJoin('bukus', 'bukus.id', '=', 'peminjams.buku_id');

        return $this->whenWhere($attr, $d);
    }
}
