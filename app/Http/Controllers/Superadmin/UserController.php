<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\{
    Inertia,
    Response
};
use App\Repositories\{
    Role\RoleRepositoryInterface,
    User\UserRepositoryInterface,
};

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * @var RoleRepositoryInterface
     */
    protected $role;

    public function __construct(
        UserRepositoryInterface $user,
        RoleRepositoryInterface $role,
    ) {
        $this->user = $user;
        $this->role = $role;

        app()['cache']->forget('spatie.permission.cache');
    }

    /**
     * Menampilkan view admin/users/index
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->role->pluck('name', 'name');
        $usersByRoles = $this->role->getUsersByRole([]);

        $countAllUsersByRoles = $this->user->count('*');

        return Inertia::render('Superadmin/ManajemenUser/DataUser/Index', [
            'roles' => $roles,
            'usersByRoles' => $usersByRoles, 'countAllUsersByRoles' => $countAllUsersByRoles
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $data = $this->user->getAll($request->all());

        $authRole = auth()->user()?->role;

        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('role', function ($data) {
                $roles = explode(',', $data->role);

                $text = '';
                foreach ($roles as $role) {
                    $text .= "<span
                    class='badge rounded-pill bg-" . $data->getRoleColor($role) . "'>
                        " . ucwords($role) . "
                    </span>";
                }

                return $text;
            })
            ->addColumn('action', function ($data) use ($authRole) {
                $button = "";

                $button .= '<div class="action-btn">';
                if ($authRole == 'superadmin' && $data->role != 'superadmin') {
                    $button .=
                        '
                        <a class="btn btn-sm btn-outline-primary login-as"  data-id="' . $data->id . '">
                            <i class="ti ti-login"></i>
                            Login as
                        </a>
                        &nbsp
                        ';
                }

                $button .= '
                        <a class="text-info edit" data-id="' . $data->id . '">
                            <i class="ti ti-edit fs-5"></i>
                        </a>
                        <a class="text-dark delete ms-2" data-id="' . $data->id . '">
                            <i class="ti ti-trash fs-5"></i>
                        </a>
                ';
                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['name', 'role', 'action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();

            if ($request->password != '' || $request->password != null) {
                // @phpstan-ignore-next-line
                $attributes['password'] = bcrypt($request->password);
            } else {
                $attributes['password'] = bcrypt('000000');
            }

            $attributes['name'] = $request->username;

            /** @var string $role */
            $role = $request->jenis_akun;
            $attributes['role'] = $role;
            /** @var User $user */
            $user = $this->user->create($attributes);

            $user->syncRoles($role);

            DB::commit();
            return to_route('superadmin.manajemen_user.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('superadmin.manajemen_user.user.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param integer $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = $this->user->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();

            if ($request->password != '' || $request->password != null) {
                // @phpstan-ignore-next-line
                $attributes['password'] = bcrypt($request->password);
            } else {
                unset($attributes['password']);
            }

            /** @var string $role */
            $role = $request->jenis_akun;
            $attributes['role'] = $role;
            /** @var User $user */
            $user = $this->user->update($attributes, $id);

            $user->syncRoles($role);

            DB::commit();
            return to_route('superadmin.manajemen_user.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('superadmin.manajemen_user.user.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     * @param integer $id
     * @return mixed
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->user->delete($id);

            DB::commit();
            return to_route('superadmin.manajemen_user.user.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('superadmin.manajemen_user.user.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
