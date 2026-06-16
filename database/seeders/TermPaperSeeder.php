<?php

namespace Database\Seeders;

use App\Models\TermPaper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noOfTermPapers = count(TermPaper::$domains);
        TermPaper::factory()->count($noOfTermPapers)->create();
    }
}
