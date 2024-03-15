<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class Anggota extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Buku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Example
 *
 * @property int $id
 * @property string $contoh
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Example newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example query()
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereContoh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereUpdatedAt($value)
 */
	class Example extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kategori
 *
 * @property int $id
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereUpdatedAt($value)
 */
	class Kategori extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kelas
 *
 * @property int $id
 * @property string $nama
 * @property string $tingkat
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereTingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereUpdatedAt($value)
 */
	class Kelas extends \Eloquent {}
}

namespace App\Models{
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
 */
	class LogPeminjam extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Model
 *
 * @property-read string|null $created_at
 * @property-read string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 */
	class Model extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Peminjam
 *
 * @property int $id
 * @property int $anggota_id
 * @property int|null $tarif_denda_id
 * @property string $tanggal_pinjam
 * @property string $tanggal_kembali
 * @property int $lama_pinjam
 * @property string $keterangan
 * @property string $kondisi_buku
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam query()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereAnggotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereKondisiBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereLamaPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereTanggalKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereTanggalPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereTarifDendaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjam whereUpdatedAt($value)
 */
	class Peminjam extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $group
 * @property string $guard_name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Petugas extends \Eloquent {}
}

namespace App\Models{
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
 */
	class RakBuku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
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
 */
	class TarifDenda extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $role
 * @property string|null $path_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_url_path_image
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePathImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

