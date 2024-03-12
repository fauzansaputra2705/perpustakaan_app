<?php

namespace App\Repositories\User;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface UserRepositoryInterface extends BaseEloquentRepositoryInterface
{

    /**
     * @param  array<mixed> $attributes
     *
     * @return mixed
     */
    public function getAll($attributes = []);

    /**
     * @return mixed
     */
    public function getUserHasRole();

    /**
     * Register new user
     *
     * @param array<mixed> $attributes
     * @return mixed
     */
    public function register($attributes);

    /**
     * @param string|array<mixed> $roles
     * @param int $userId
     * @return mixed
     */
    public function syncRoles($roles, $userId);

    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
