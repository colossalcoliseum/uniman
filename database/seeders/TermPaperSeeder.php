<?php

namespace Database\Seeders;

use App\Models\TermPaper;
use Database\Factories\TermPaperFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noOfTermPapers = count(TermPaperFactory::$domains);
        TermPaper::factory()->count($noOfTermPapers)->create();
    }
}
