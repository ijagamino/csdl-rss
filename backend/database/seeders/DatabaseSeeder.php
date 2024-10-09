<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $role = Role::create(['name' => 'student']);
        $permission = Permission::create(['name' => 'create reports']);

        User::factory()->create([
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => 'student',
            'first_name' => 'Student',
            'last_name' => 'User',
        ]);

        User::factory()->create([
            'username' => 'staff',
            'email' => 'staff@example.com',
            'password' => 'staff',
            'first_name' => 'Staff',
            'last_name' => 'User',
            'role' => 'staff',
        ]);

        User::factory(10)->create();

        $this->call([
            ReportSeeder::class,
        ]);

        $this->call([
            AppointmentSeeder::class,
        ]);

        $this->call([
            ArchiveSeeder::class,
        ]);

        $this->call([
            FeedbackSeeder::class,
        ]);
    }
}
