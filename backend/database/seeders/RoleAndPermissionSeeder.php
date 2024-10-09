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
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'create reports']);
        Permission::create(['name' => 'edit reports']);
        Permission::create(['name' => 'delete reports']);

        $adminRole = Role::create(['name' => 'admin']);
        $facultyRole = Role::create(['name' => 'faculty']);
        $studentRole = Role::create(['name' => 'student']);

        $adminRole->givePermissionTo([
            'create uers',
            'edit users',
            'delete users',
        ]);

        $facultyRole->givePermissionTo([
            'edit reports',
        ]);

        $studentRole->givePermissionTo([
            'create reports',
            'edit reports',
            'delete reports',
        ]);
    }
}
