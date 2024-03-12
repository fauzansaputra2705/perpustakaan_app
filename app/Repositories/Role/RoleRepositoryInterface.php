<?php

namespace App\Repositories\Role;

use App\Repositories\BaseEloquentRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Permission\Contracts\Role as SpatieRole;

interface RoleRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * @param string $name
     * @param string|null $guardName
     * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
     */
    public function findByName(string $name, $guardName = null);

    /**
     * @param string $role
     * @param array|mixed $permissions
     * @return mixed
     */
    public function setRolePermissions(string $role, $permissions);

    /**
     * @param   array<string>  $role
     * @return  mixed
     */
    public function getUsersByRole($role);

    /**
     * @param SpatieRole $role
     * @return Collection<int,mixed>
     */
    public function roleHasPermissions($role): Collection;

    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder;
}
