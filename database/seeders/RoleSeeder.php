<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'see user list']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'see user activity']);
        Permission::create(['name' => 'delete activity']);

        $role = Role::create(['name' => 'admin']);
        $role->syncPermissions([
            'see user list',
            'create user',
            'edit user',
            'update user',
            'delete user',
            'view user',
            'create role',
            'edit role',
            'delete role',
            'view role',
            'create permission',
            'edit permission',
            'delete permission',
            'view permission',
            'see user activity',
            'delete activity',
        ]);

        $role = Role::create(['name' => 'moderator']);
        $role->syncPermissions([
            'see user list',
            'create user',
            'view user',
            'see user activity',
        ]);

        $role = Role::create(['name' => 'basic']);
        $role->syncPermissions([
            'view user',
            'see user list',
        ]);
    }
}
