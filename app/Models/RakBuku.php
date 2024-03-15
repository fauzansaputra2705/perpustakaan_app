<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\RakBuku
 *
 * @property int $id
 * @property string $nama
 * @property string|null $lokasi
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku query()
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RakBuku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RakBuku extends Model
{
    use HasFactory;

    protected $table = 'rak_bukus';
}
