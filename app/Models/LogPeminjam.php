<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\LogPeminjam
 *
 * @property int $id
 * @property int $peminjam_id
 * @property int $petugas_id
 * @property string $status_peminjam
 * @property string|null $keterangan_peminjam
 * @property string $kondisi_buku
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereKeteranganPeminjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereKondisiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam wherePeminjamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam wherePetugasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereStatusPeminjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogPeminjam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LogPeminjam extends Model
{
    use HasFactory;

    protected $table = 'log_peminjams';
}
