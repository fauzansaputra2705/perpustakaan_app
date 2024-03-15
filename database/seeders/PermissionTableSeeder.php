<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([
            'data kategori' => [
                'create data kategori',
                'view data kategori',
                'edit data kategori',
                'delete data kategori',
            ],

            'data rak buku' => [
                'create data rak buku',
                'view data rak buku',
                'edit data rak buku',
                'delete data rak buku',
            ],

            'data tarif denda' => [
                'create data tarif denda',
                'view data tarif denda',
                'edit data tarif denda',
                'delete data tarif denda',
            ],

            'data kelas' => [
                'create data kelas',
                'view data kelas',
                'edit data kelas',
                'delete data kelas',
            ],

            'data buku' => [
                'create data buku',
                'view data buku',
                'edit data buku',
                'delete data buku',
            ],

            'data petugas' => [
                'create data petugas',
                'view data petugas',
                'edit data petugas',
                'delete data petugas',
            ],

            'data anggota' => [
                'create data anggota',
                'view data anggota',
                'edit data anggota',
                'delete data anggota',
            ],
        ]);

        $permissions->map(function ($permission, $group) {
            collect($permission)->map(function ($name) use ($group) {
                $guard_name = 'web';

                ModelsPermission::query()
                    ->updateOrCreate(compact('name'), compact('name', 'group', 'guard_name'));
            });
        });
    }
}
