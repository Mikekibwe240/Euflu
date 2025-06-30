<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' => true,
        ]);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' => false,
        ]);

        // Créer les rôles s'ils n'existent pas
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

        // Assigner les rôles
        $superAdmin->assignRole($roleSuperAdmin);
        $admin->assignRole($roleAdmin);
    }
}
