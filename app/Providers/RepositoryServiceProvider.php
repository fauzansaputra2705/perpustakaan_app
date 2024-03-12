<?php

namespace App\Providers;

use App\Repositories\Crud\{CrudRepository, CrudRepositoryInterface};
use App\Repositories\User\{UserRepository, UserRepositoryInterface};
use App\Repositories\Role\{RoleRepository, RoleRepositoryInterface};
use App\Repositories\Pendidik\{PendidikRepository, PendidikRepositoryInterface};
use App\Repositories\RiwayatPendidikan\{RiwayatPendidikanRepository, RiwayatPendidikanRepositoryInterface};
use App\Repositories\RiwayatPelatihan\{RiwayatPelatihanRepository, RiwayatPelatihanRepositoryInterface};
use App\Repositories\Pengalaman\{PengalamanRepository, PengalamanRepositoryInterface};
use App\Repositories\Pendaftaran\{PendaftaranRepository, PendaftaranRepositoryInterface,};
use App\Repositories\Pendaftaran\DokumenPendaftaran\{
    DokumenPendaftaranRepository,
    DokumenPendaftaranRepositoryInterface
};
use App\Repositories\Pendaftaran\KeteranganPendaftaran\{
    KeteranganPendaftaranRepository,
    KeteranganPendaftaranRepositoryInterface
};
use App\Repositories\Pendaftaran\KuotaPendaftaran\{KuotaPendaftaranRepository, KuotaPendaftaranRepositoryInterface};
use App\Repositories\DokumenPendidik\{DokumenPendidikRepository, DokumenPendidikRepositoryInterface};
use App\Repositories\Verifikator\{VerifikatorRepository, VerifikatorRepositoryInterface};
use App\Repositories\Pengajuan\{PengajuanRepository, PengajuanRepositoryInterface,};
use App\Repositories\MadrasahBinaan\{MadrasahBinaanRepository, MadrasahBinaanRepositoryInterface,};
use App\Repositories\Pengajuan\LogPengajuan\{LogPengajuanRepository, LogPengajuanRepositoryInterface};
use App\Repositories\PengawasMadrasah\{PengawasMadrasahRepository, PengawasMadrasahRepositoryInterface};
use App\Repositories\PengawasMadrasah\Pengajuan\{
    PengajuanPengawasMadrasahRepository,
    PengajuanPengawasMadrasahRepositoryInterface
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * define your repositories here
     */
    // @phpstan-ignore-next-line
    protected $repositories = [
        // [
        //     ModelRepositoryInterface::class,
        //     ModelRepository::class
        // ],
        [
            CrudRepositoryInterface::class,
            CrudRepository::class
        ],
        [
            UserRepositoryInterface::class,
            UserRepository::class
        ],
        [
            RoleRepositoryInterface::class,
            RoleRepository::class
        ],
        [
            PendidikRepositoryInterface::class,
            PendidikRepository::class
        ],
        [
            RiwayatPendidikanRepositoryInterface::class,
            RiwayatPendidikanRepository::class
        ],
        [
            RiwayatPelatihanRepositoryInterface::class,
            RiwayatPelatihanRepository::class
        ],
        [
            PengalamanRepositoryInterface::class,
            PengalamanRepository::class
        ],
        [
            PendaftaranRepositoryInterface::class,
            PendaftaranRepository::class
        ],
        [
            DokumenPendaftaranRepositoryInterface::class,
            DokumenPendaftaranRepository::class
        ],
        [
            KeteranganPendaftaranRepositoryInterface::class,
            KeteranganPendaftaranRepository::class
        ],
        [
            KuotaPendaftaranRepositoryInterface::class,
            KuotaPendaftaranRepository::class
        ],
        [
            DokumenPendidikRepositoryInterface::class,
            DokumenPendidikRepository::class
        ],
        [
            VerifikatorRepositoryInterface::class,
            VerifikatorRepository::class
        ],
        [
            PengajuanRepositoryInterface::class,
            PengajuanRepository::class
        ],
        [
            MadrasahBinaanRepositoryInterface::class,
            MadrasahBinaanRepository::class
        ],
        [
            LogPengajuanRepositoryInterface::class,
            LogPengajuanRepository::class
        ],
        [
            PengawasMadrasahRepositoryInterface::class,
            PengawasMadrasahRepository::class
        ],
        [
            PengajuanPengawasMadrasahRepositoryInterface::class,
            PengajuanPengawasMadrasahRepository::class
        ],
    ];

    public function register()
    {
        foreach ($this->repositories as $repository) {
            $this->app->bind($repository[0], $repository[1]);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
