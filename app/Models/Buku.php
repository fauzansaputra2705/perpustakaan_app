<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Buku
 *
 * @property int $id
 * @property string $judul
 * @property int $kategori_id
 * @property int|null $rak_buku_id
 * @property string $isbn
 * @property string $writer
 * @property string $reviewer
 * @property string $translator
 * @property string $adapter
 * @property string $cover_designer
 * @property string $designer
 * @property string $ilustrator
 * @property string $editor
 * @property string $publisher
 * @property int $jumlah_halaman
 * @property int $jumlah_stok
 * @property int $tahun_terbit
 * @property string $sinopsis
 * @property string $gambar
 * @property int $status_publish
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Buku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku query()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereAdapter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereCoverDesigner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereDesigner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereIlustrator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereJumlahHalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereJumlahStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereRakBukuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereReviewer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereSinopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereStatusPublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereTahunTerbit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereTranslator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereWriter($value)
 * @mixin \Eloquent
 */
class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
}
