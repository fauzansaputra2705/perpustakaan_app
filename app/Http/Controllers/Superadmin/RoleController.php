<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetRolePermissionRequest;
use App\Models\Permission;
use App\Repositories\Crud\CrudRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * @var RoleRepositoryInterface
     */
    protected $role;

    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * @var CrudRepositoryInterface
     */
    protected $permission;

    public function __construct(
        RoleRepositoryInterface $role,
        UserRepositoryInterface $user,
        CrudRepositoryInterface $crud,
    ) {
        $this->role = $role;
        $this->user = $user;

        $this->permission = new $crud;
        $this->permission->setModel(new Permission());
    }

    /**
     * Menampilkan view admin/roles/index
     *
     */
    public function index(Request $request): Response
    {
        $usersByRoles = $this->role->getUsersByRole([]);
        $countAllUsersByRoles = $this->user->count('*');
        $namePermissions = $this->permission->getModel()->select('group')->groupBy('group')->get();
        $permissions = $this->permission->all();
        /** @var string $roleName */
        $roleName = $request->has('name') && $request->name != "" ? $request->name : 'superadmin';

        $roleSelected  = null;
        $hasPermissions  = null;
        if (!empty($roleName)) {
            $roleSelected  = $this->role->findByName($roleName);
            $hasPermissions = $this->role->roleHasPermissions($roleSelected)->toArray();
        }

        return Inertia::render('Superadmin/Roles/Index', [
            'requestName' => $request->name,
            'usersByRoles' => $usersByRoles,
            'countAllUsersByRoles' => $countAllUsersByRoles,
            'namePermissions' => $namePermissions,
            'permissions' => $permissions,
            'roleName' => $roleName,
            'roleSelected' => $roleSelected,
            'hasPermissions' => $hasPermissions
        ]);
    }

    /**
     * Set permissions to role selected
     *
     * @param SetRolePermissionRequest $request
     * @param string $role
     *
     */
    public function setRolePermissions(SetRolePermissionRequest $request, $role): mixed
    {
        DB::beginTransaction();
        try {
            $role = $this->role->setRolePermissions($role, $request->permissions);

            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
