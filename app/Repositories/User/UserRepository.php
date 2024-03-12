<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model()
    {
        return new User();
    }

    /**
     * @param  array<mixed> $attributes
     *
     * @return mixed
     */
    public function getAll($attributes = [])
    {
        return $this->getModel()->query()
            ->when(isset($attributes['role']) && $attributes['role'] != "", function ($query) use ($attributes) {
                $query->whereHas('roles', fn ($query) => $query->where('name', $attributes['role']));
            })
            ->orderBy('role');
    }

    /**
     * @return mixed
     */
    public function getUserHasRole()
    {
        return $this->getModel()
            ->whereHas('roles')
            ->get();
    }

    /**
     * Register new user
     *
     * @param array<mixed> $attributes
     * @return mixed
     */
    public function register($attributes)
    {
        $user = $this->getModel()->create($attributes);

        // @phpstan-ignore-next-line
        $user->assignRole($attributes['level']);

        return $user;
    }

    /**
     * @param string|array<mixed> $roles
     * @param int $userId
     * @return mixed
     */
    public function syncRoles($roles, $userId)
    {
        $user = $this->getModel()->find($userId);

        // @phpstan-ignore-next-line
        $user->syncRoles($roles);

        return $user;
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
            $selects = 'users.*';
        }

        $d = $this->getModel()
            ->query()
            ->select($selects);

        return $this->whenWhere($attr, $d);
    }
}
