<?php

namespace Modules\UserModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\RoleModule\Entities\Role;
use Modules\UserModule\Entities\User;


class UserModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'is_verified' => true,
            ]
        );

        // Ensure the admin role for 'web' guard exists
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign role to admin user
        $admin->assignRole($adminRole);
    }
}
