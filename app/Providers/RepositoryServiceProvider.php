<?php

namespace App\Providers;

use App\Repositories\Crud\{CrudRepository, CrudRepositoryInterface};
use App\Repositories\User\{UserRepository, UserRepositoryInterface};
use App\Repositories\Role\{RoleRepository, RoleRepositoryInterface};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * define your repositories here
     */
    // @phpstan-ignore-next-line
    protected $repositories = [
        // [
        //     ExampleRepositoryInterface::class,
        //     ExampleRepository::class
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
