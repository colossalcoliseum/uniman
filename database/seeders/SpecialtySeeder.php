<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Database\Factories\SpecialtyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numOfSpecialties = count(SpecialtyFactory::$specialties);
        Specialty::factory()->count($numOfSpecialties)->create();
    }
}
