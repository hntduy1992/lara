<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RBACSeeder extends Seeder
{
    public function run(): void
    {
        /// 1. Tạo một Permission
        $createUsers = Permission::create(['name' => 'create-users']);
        $editUsers = Permission::create(['name' => 'edit-users']);
        $deleteUsers = Permission::create(['name' => 'delete-users']);
        $viewUsers = Permission::create(['name' => 'view-users']);

// 2. Tạo một Role
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $coAdminRole = Role::create(['name' => 'co-admin']);
        $userRole = Role::create(['name' => 'user']);

// 3. Gán Permission vào Role
        $superAdminRole->givePermissionTo($createUsers);
        $superAdminRole->givePermissionTo($editUsers);
        $superAdminRole->givePermissionTo($deleteUsers);
        $superAdminRole->givePermissionTo($viewUsers);
        $adminRole->givePermissionTo($createUsers);
        $adminRole->givePermissionTo($editUsers);
        $adminRole->givePermissionTo($deleteUsers);
        $adminRole->givePermissionTo($viewUsers);
        $coAdminRole->givePermissionTo($createUsers);
        $coAdminRole->givePermissionTo($editUsers);
        $coAdminRole->givePermissionTo($deleteUsers);
        $coAdminRole->givePermissionTo($viewUsers);
    }
}
