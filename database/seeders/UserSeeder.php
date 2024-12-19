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
                'password' => Hash::make('root'), 
            ]);

            $role = Role::firstOrCreate(['name' => 'Admin']);
        } else {
            $role = Role::where('name', 'Admin')->first();
        }

        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);

        $user->assignRole($role);
    }
}
