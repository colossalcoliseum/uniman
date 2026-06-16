<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RemarkSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            InstitutionSeeder::class,
            FacultySeeder::class,
            SpecialtySeeder::class,
            TermPaperSeeder::class,
            ConsultationSeeder::class,
            RecensionSeeder::class,
        ]
        );
    }
}
