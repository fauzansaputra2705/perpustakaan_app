<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function model()
    {
        return new SpatieRole();
    }

    /**
     * @param string $name
     * @param string|null $guardName
     * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
     */
    public function findByName(string $name, $guardName = null)
    {
        return SpatieRole::findByName($name, $guardName);
    }

    /**
     * @param string $role
     * @param array|mixed $permissions
     * @return mixed
     */
    public function setRolePermissions($role, $permissions)
    {
        $role = $this->findByName($role);
        // @phpstan-ignore-next-line
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * @param   array<string>  $role
     * @return  mixed
     */
    public function getUsersByRole($role = [])
    {
        $authRole = auth()->user()?->role;
        $authProvinsiId = auth()->user()?->provinsi_id;
        $authKabupatenId = auth()->user()?->kabupaten_id;

        return SpatieRole::when(count($role) > 0, function ($query) use ($role) {
            $query->whereIn('name', $role);
        })
            ->with('users')
            ->when($authRole == 'kanwil', function ($query) use ($authProvinsiId) {
                $query->withCount(['users' => function ($query) use ($authProvinsiId) {
                    $query->where('provinsi_id', $authProvinsiId);
                }]);
            })
            ->when($authRole == 'kabko', function ($query) use ($authKabupatenId) {
                $query->withCount(['users' => function ($query) use ($authKabupatenId) {
                    $query->where('kabupaten_id', $authKabupatenId);
                }]);
            })
            ->when($authRole != 'kanwil' && $authRole != 'kabko', function ($query) {
                $query->withCount('users');
            })
            ->get();
    }

    /**
     * @param SpatieRole $role
     * @return Collection<int,mixed>
     */
    public function roleHasPermissions($role): Collection
    {
        return DB::table('role_has_permissions')
            ->select('permissions.name')
            ->join('permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_id', $role->id)
            ->pluck('name');
    }

    /**
     * @param array<array<mixed>> $attr
     * @param Array<string> $select
     */
    public function queryWhere($attr, $select): Builder
    {
        $selects = '';
        if (count($select) > 0) {
            $selects = $select;
        } else {
            $selects = 'roles.*';
        }

        $d = $this->getModel()
            ->query()
            ->select($selects);

        return $this->whenWhere($attr, $d);
    }
}
