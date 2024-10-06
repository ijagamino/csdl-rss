<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Report;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory()->create([
            'report_id' => Report::factory()->create(['user_id' => '1']),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
        ]);

        Appointment::factory()->create([
            'report_id' => Report::factory()->create(['user_id' => '1']),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        Appointment::factory()->create([
            'report_id' => Report::factory()->create(['user_id' => '1']),
            'start_time' => '11:00:00',
            'end_time' => '12:00:00',
        ]);
    }
}
