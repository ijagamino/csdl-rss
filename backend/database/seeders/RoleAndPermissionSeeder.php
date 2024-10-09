<?php

namespace Database\Seeders;

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
        Permission::firstOrcreate(['name' => 'create users']);
        Permission::firstOrcreate(['name' => 'edit users']);
        Permission::firstOrcreate(['name' => 'delete users']);

        Permission::firstOrCreate(['name' => 'view all reports']);
        Permission::firstOrCreate(['name' => 'view own reports']);
        Permission::firstOrCreate(['name' => 'create reports']);
        Permission::firstOrCreate(['name' => 'edit reports']);
        Permission::firstOrCreate(['name' => 'approve reports']);
        Permission::firstOrCreate(['name' => 'delete reports']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        $adminRole->givePermissionTo([
            'create users',
            'edit users',
            'delete users',
        ]);

        $staffRole->givePermissionTo([
            'view all reports',
            'approve reports',
        ]);

        $studentRole->givePermissionTo([
            'view own reports',
            'create reports',
            'edit reports',
            'delete reports',
        ]);
    }
}
