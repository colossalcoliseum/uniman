<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\TermPaper;
use Database\Factories\TermPaperFactory;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noOfTermPapers = count(TermPaperFactory::$domains);
        Consultation::factory()->count($noOfTermPapers * 3)->create();
    }
}
