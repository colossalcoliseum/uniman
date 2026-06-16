<?php

namespace Database\Seeders;

use App\Enums\Remark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Remark as RemarkModel;

class RemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Remark::cases() as $remark) {
            RemarkModel::create([
                'name' => $remark->label(),
                'slug' => $remark->slug(),
                'ects_score' => $remark->ectsScore(),
                'gpa_score' => $remark->gpaScore(),
                'bg_score' => $remark->bgScore(),
                'letter_grade' => $remark->letterGrading(),
                'passing_score' => $remark->passingScore(),
            ]);
        }
    }
}
