<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DendaPeminjam
 *
 * @property int $id
 * @property int $peminjam_id
 * @property int $tarif_denda_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam query()
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam wherePeminjamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam whereTarifDendaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DendaPeminjam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DendaPeminjam extends Model
{
    use HasFactory;
}
