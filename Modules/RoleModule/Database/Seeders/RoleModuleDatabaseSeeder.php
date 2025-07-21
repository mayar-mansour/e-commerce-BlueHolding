<?php

namespace Modules\RoleModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear permission cache
        app()['cache']->forget('spatie.permission.cache');

        $now = now();

        // === Define roles ===
        $roles = [
            'admin' => 'api',
            'vendor' => 'api',
            'customer' => 'api',
            'admin_web' => 'web',
        ];

        foreach ($roles as $roleName => $guard) {
            DB::table('roles')->updateOrInsert(
                ['name' => $roleName, 'guard_name' => $guard],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // === Define permissions ===
        $permissions = [
            ['name' => 'create and view order', 'guard_name' => 'api'],
            ['name' => 'view and rate product', 'guard_name' => 'api'],
            ['name' => 'create, edit, delete', 'guard_name' => 'api'],
            ['name' => 'create, edit', 'guard_name' => 'api'],
            ['name' => 'access dashboard', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $perm) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $perm['name'], 'guard_name' => $perm['guard_name']],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // === Attach permissions to roles ===
        $rolePermissions = [
            'customer' => ['create and view order', 'view and rate product'],
            'admin' => ['create, edit, delete'],
            'vendor' => ['create, edit'],
            'admin_web' => ['access dashboard'],
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id');

            foreach ($permissionNames as $permissionName) {
                $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');

                if ($roleId && $permissionId) {
                    DB::table('role_has_permissions')->updateOrInsert(
                        ['role_id' => $roleId, 'permission_id' => $permissionId],
                        ['created_at' => $now, 'updated_at' => $now]
                    );
                }
            }
        }

        // === Optionally assign roles and permissions to test user(s) ===
        $users = [
            [
                'id' => 1,
                'model_type' => 'Modules\UserModule\Entities\User',
                'role' => 'admin',
                'permissions' => ['create, edit, delete']
            ]
        ];

        foreach ($users as $user) {
            $roleId = DB::table('roles')->where('name', $user['role'])->value('id');

            if ($roleId) {
                // Assign role
                DB::table('model_has_roles')->updateOrInsert(
                    [
                        'model_id' => $user['id'],
                        'model_type' => $user['model_type']
                    ],
                    [
                        'role_id' => $roleId,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );
            }

            foreach ($user['permissions'] as $permissionName) {
                $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');

                if ($permissionId) {
                    DB::table('model_has_permissions')->updateOrInsert(
                        [
                            'model_id' => $user['id'],
                            'model_type' => $user['model_type'],
                            'permission_id' => $permissionId,
                        ],
                        [
                            'created_at' => $now,
                            'updated_at' => $now
                        ]
                    );
                }
            }
        }
    }
}
