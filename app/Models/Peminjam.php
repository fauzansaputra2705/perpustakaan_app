<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Peminjam
 *
 * @property int $id
 * @property int $anggota_id
 * @property int $buku_id
 * @property string $tanggal_pinjam
 * @property string|null $tanggal_kembali
 * @property int $lama_pinjam
 * @property string $keterangan
 * @property string $kondisi_buku_minjam
 * @property string $kondisi_buku_kembali
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam query()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereAnggotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereBukuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereKondisiBukuKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereKondisiBukuMinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereLamaPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereTanggalKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereTanggalPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Peminjam extends Model
{
    use HasFactory;

    protected $table = 'peminjams';
}
