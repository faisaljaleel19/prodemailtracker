<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'view-dashboard']);
        Permission::create(['name' => 'create-tracker']);
        Permission::create(['name' => 'upload-tracker']);
        Permission::create(['name' => 'view-tracker']);
        Permission::create(['name' => 'send-activation-mail']);

        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);
        $tlRole = Role::create(['name' => 'TeamLead']);

        $adminRole->givePermissionTo([
            'view-dashboard',
            'create-users',
            'edit-users',
            'delete-users',
            'create-tracker',
            'upload-tracker',
            'view-tracker',
            'send-activation-mail',
        ]);

        $userRole->givePermissionTo([
            'view-dashboard',
            'create-tracker',
            'upload-tracker',
            'view-tracker',
            'send-activation-mail',
        ]);

        $tlRole->givePermissionTo([
            'view-dashboard',
            'view-tracker',
        ]);
    }
}
