<?php

namespace Database\Seeders;

use App\Models\Archive;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Archive::factory(3)->create([
            'report_id' => Report::factory()->create(['user_id' => '1', 'status' => 'completed']),
            'user_id' => User::factory()->create(),
        ]);
    }
}
