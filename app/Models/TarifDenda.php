<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\TarifDenda
 *
 * @property int $id
 * @property string $kategori
 * @property int $denda
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda query()
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda whereDenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TarifDenda whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TarifDenda extends Model
{
    use HasFactory;

    protected $table = 'tarif_dendas';
}
