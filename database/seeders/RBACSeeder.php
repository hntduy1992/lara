<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RBACSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Roles
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Quyền cao nhất, toàn quyền với hệ thống',
                'is_system' => true,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Quản trị viên hệ thống',
                'is_system' => true,
            ],
            [
                'name' => 'co-admin',
                'display_name' => 'Co-Admin',
                'description' => 'Đồng cấp quản trị viên hệ thống',
                'is_system' => false,
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Quản lý nội dung',
                'is_system' => false,
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Người dùng thông thường',
                'is_system' => false,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert(array_merge($role, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2. Tạo Permissions
        $permissionGroups = [
            'users' => [
                ['name' => 'users.view', 'display_name' => 'Xem danh sách người dùng'],
                ['name' => 'users.create', 'display_name' => 'Tạo người dùng mới'],
                ['name' => 'users.edit', 'display_name' => 'Chỉnh sửa người dùng'],
                ['name' => 'users.delete', 'display_name' => 'Xóa người dùng'],
                ['name' => 'users.manage_roles', 'display_name' => 'Quản lý vai trò người dùng'],
            ],
            'roles' => [
                ['name' => 'roles.view', 'display_name' => 'Xem danh sách vai trò'],
                ['name' => 'roles.create', 'display_name' => 'Tạo vai trò mới'],
                ['name' => 'roles.edit', 'display_name' => 'Chỉnh sửa vai trò'],
                ['name' => 'roles.delete', 'display_name' => 'Xóa vai trò'],
            ],
            'permissions' => [
                ['name' => 'permissions.view', 'display_name' => 'Xem danh sách quyền'],
                ['name' => 'permissions.assign', 'display_name' => 'Gán quyền cho vai trò'],
            ],
            'oauth' => [
                ['name' => 'oauth.clients.view', 'display_name' => 'Xem OAuth clients'],
                ['name' => 'oauth.clients.create', 'display_name' => 'Tạo OAuth client'],
                ['name' => 'oauth.clients.edit', 'display_name' => 'Chỉnh sửa OAuth client'],
                ['name' => 'oauth.clients.delete', 'display_name' => 'Xóa OAuth client'],
                ['name' => 'oauth.tokens.revoke', 'display_name' => 'Thu hồi token'],
            ],
            'settings' => [
                ['name' => 'settings.view', 'display_name' => 'Xem cài đặt'],
                ['name' => 'settings.edit', 'display_name' => 'Chỉnh sửa cài đặt'],
            ],
            'audit' => [
                ['name' => 'audit.view', 'display_name' => 'Xem nhật ký hệ thống'],
            ],
        ];

        $permissionIds = [];
        foreach ($permissionGroups as $group => $permissions) {
            foreach ($permissions as $permission) {
                $id = DB::table('permissions')->insertGetId(array_merge($permission, [
                    'group' => $group,
                    'description' => $permission['display_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $permissionIds[$permission['name']] = $id;
            }
        }

        // 3. Gán Permissions cho Roles
        $rolePermissions = [
            'super_admin' => array_values($permissionIds), // Tất cả quyền
            'admin' => [
                $permissionIds['users.view'],
                $permissionIds['users.create'],
                $permissionIds['users.edit'],
                $permissionIds['users.delete'],
                $permissionIds['users.manage_roles'],
                $permissionIds['roles.view'],
                $permissionIds['permissions.view'],
                $permissionIds['oauth.clients.view'],
                $permissionIds['oauth.clients.create'],
                $permissionIds['oauth.clients.edit'],
                $permissionIds['oauth.tokens.revoke'],
                $permissionIds['settings.view'],
                $permissionIds['settings.edit'],
                $permissionIds['audit.view'],
            ],
            'manager' => [
                $permissionIds['users.view'],
                $permissionIds['users.edit'],
                $permissionIds['settings.view'],
            ],
            'user' => [], // User không có quyền admin nào
        ];

        $roles = DB::table('roles')->get();
        foreach ($roles as $role) {
            if (isset($rolePermissions[$role->name])) {
                foreach ($rolePermissions[$role->name] as $permissionId) {
                    DB::table('permission_role')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 4. Tạo OAuth Scopes
        $scopes = [
            ['name' => 'read:user', 'display_name' => 'Đọc thông tin người dùng', 'is_default' => true],
            ['name' => 'write:user', 'display_name' => 'Chỉnh sửa thông tin người dùng', 'is_default' => false],
            ['name' => 'read:profile', 'display_name' => 'Đọc hồ sơ', 'is_default' => true],
            ['name' => 'write:profile', 'display_name' => 'Chỉnh sửa hồ sơ', 'is_default' => false],
            ['name' => '*', 'display_name' => 'Toàn quyền', 'is_default' => false],
        ];

        foreach ($scopes as $scope) {
            DB::table('oauth_scopes')->insert(array_merge($scope, [
                'description' => $scope['display_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('RBAC seeded successfully!');
    }
}
