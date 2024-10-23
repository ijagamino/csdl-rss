<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        //
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
        ])->assignRole('admin');

        User::factory()->create([
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => 'student',
            'first_name' => 'Student',
            'last_name' => 'User',
        ])->assignRole('student');

        User::factory()->create([
            'username' => 'staff',
            'email' => 'staff@example.com',
            'password' => 'staff',
            'first_name' => 'Staff',
            'last_name' => 'User',
        ])->assignRole('staff');

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('student');
        });

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
