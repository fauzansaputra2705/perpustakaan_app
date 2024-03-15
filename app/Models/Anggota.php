<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Anggota
 *
 * @property int $id
 * @property int $user_id
 * @property int $kelas_id
 * @property string $kode_anggota
 * @property string $nama
 * @property string $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $email
 * @property string $telpon
 * @property string $alamat
 * @property string|null $foto
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereKelasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereKodeAnggota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anggota whereUserId($value)
 * @mixin \Eloquent
 */
class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';
}
