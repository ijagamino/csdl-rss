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
        Permission::firstOrCreate(['name' => 'update reports']);
        Permission::firstOrCreate(['name' => 'delete reports']);

        Permission::firstOrCreate(['name' => 'view all appointments']);
        Permission::firstOrCreate(['name' => 'view own appointments']);
        Permission::firstOrCreate(['name' => 'update appointments']);
        Permission::firstOrCreate(['name' => 'approve appointments']);
        Permission::firstOrCreate(['name' => 'complete appointments']);
        Permission::firstOrCreate(['name' => 'cancel appointments']);

        Permission::firstOrCreate(['name' => 'view all archives']);
        Permission::firstOrCreate(['name' => 'view own archives']);

        Permission::firstOrCreate(['name' => 'view all feedbacks']);
        Permission::firstOrCreate(['name' => 'view own feedbacks']);
        Permission::firstOrCreate(['name' => 'create feedbacks']);

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
            'view all appointments',
            'view all archives',
            'approve appointments',
            'complete appointments',
            'view all feedbacks',
        ]);

        $studentRole->givePermissionTo([
            'view own reports',
            'create reports',
            'update reports',
            'delete reports',
            'view own appointments',
            'update appointments',
            'cancel appointments',
            'view own archives',
            'view own feedbacks',
            'create feedbacks',
        ]);
    }
}
