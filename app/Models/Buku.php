<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Buku
 *
 * @property int $id
 * @property int $kategori_id
 * @property int|null $rak_buku_id
 * @property string $title
 * @property string $slug
 * @property string $publish_date
 * @property string $sinopsis
 * @property string $publisher
 * @property string $author
 * @property string $language
 * @property string|null $isbn
 * @property int $jumlah_stok
 * @property int $tahun_terbit
 * @property string $cover
 * @property int $status_publish
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read string $full_url_cover
 * @property-read string $name_status_publish
 * @method static \Illuminate\Database\Eloquent\Builder|Buku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku query()
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereJumlahStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereRakBukuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereSinopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereStatusPublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereTahunTerbit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Buku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    /**
     * @var array<string>
     */
    protected $appends = ['name_status_publish', 'full_url_cover'];

    public function getNameStatusPublishAttribute(): string
    {
        return $this->status_publish == 1 ? 'Publish' : 'Unpublish';
    }

    /**
     * Mengambil full url path image
     * @return string
     */
    public function getFullUrlCoverAttribute(): string
    {
        if (strpos($this->cover, "kemdikbud") !== false) {
            return $this->cover;
        } else {
            return loadFile($this->cover);
        }
    }
}
