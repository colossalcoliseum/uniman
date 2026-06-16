<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\TermPaper;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noOfTermPapers = count(TermPaper::$domains);
        Consultation::factory()->count($noOfTermPapers * 3)->create();
    }
}
