<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Petugas
 *
 * @property int $id
 * @property int $user_id
 * @property string $kode_petugas
 * @property string $email
 * @property string $nama
 * @property string $jenis_kelamin
 * @property string $telpon
 * @property string $alamat
 * @property string|null $foto
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read string|null $full_url_foto
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereKodePetugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Petugas whereUserId($value)
 * @mixin \Eloquent
 */
class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    /**
     * @var array<string>
     */
    protected $appends = ['full_url_foto'];

    /**
     * Mengambil full url path image
     * @return string|null
     */
    public function getFullUrlFotoAttribute(): string|null
    {
        return loadFile($this->foto);
    }
}
