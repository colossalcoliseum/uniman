<?php

namespace Database\Seeders;

use App\Models\Recension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recension::factory()->count(50)->create();
    }
}
