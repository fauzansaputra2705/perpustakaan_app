<?php

namespace Database\Seeders;

use App\Models\m_kantor;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $data = collect([
            [
                'name' => "SuperAdmin",
                'email' => 'superadmin@example.com',
                'role' => 'superadmin'
            ],
            [
                'name' => "Petugas",
                'email' => 'petugas@example.com',
                'role' => 'petugas'
            ],
            [
                'name' => "Siswa",
                'email' => 'siswa@example.com',
                'role' => 'siswa'
            ],
        ]);

        $data->map(function ($data) {
            $name = $data['name'];
            $email = $data['email'];
            $role = $data['role'];
            $emailVerifiedAt = now();
            $password = bcrypt('000000');

            $user = User::updateOrCreate([
                'email' => $email
            ], [
                'name'              => $name,
                'email'             => $email,
                'role'              => $role,
                'email_verified_at' => $emailVerifiedAt,
                'password'          => $password
            ]);

            $user->syncRoles($user->role);
        });
    }
}
