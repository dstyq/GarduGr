<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah pengguna dengan nama 'Root' sudah ada
        $user = User::where('name', 'Root')->first();

        // Jika pengguna tidak ada, buat pengguna baru
        if (!$user) {
            $user = User::create([
                'name' => 'Root',
                'username' => 'root',
                'email' => 'root@root.com',
                'password' => Hash::make('root'), // Hash password
            ]);

            // Buat role 'Admin' jika belum ada
            $role = Role::firstOrCreate(['name' => 'Admin']);
        } else {
            // Jika pengguna sudah ada, ambil role 'Admin'
            $role = Role::where('name', 'Admin')->first();
        }

        // Ambil semua permissions dan sinkronisasikan dengan role
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);

        // Assign role kepada pengguna
        $user->assignRole($role);
    }
}
