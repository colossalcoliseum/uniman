<?php

namespace Database\Factories;

use App\Enums\TermPaperStatus;
use App\Enums\UserRole;
use App\Models\Remark;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recension>
 */
class RecensionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $termPaper = TermPaper::inRandomOrder()->first();

        return [
            'term_paper_id' => $termPaper->id,
            'title' => $termPaper->title,
            'remark_id' => Remark::inRandomOrder()->value('id'),
            'reviewer_id' => $this->getReviewerId(),
            'status' => $this->faker->randomElement(TermPaperStatus::cases()),
            'final_verdict' => $this->faker->sentence(20),
            'passed' => $this->faker->boolean(),

        ];

    }
    private function getReviewerId(): ?int
    {
        return User::whereIn('role', [
            UserRole::PROFESSOR->value,
            UserRole::ASSOCIATE_PROFESSOR->value,
        ])->inRandomOrder()->value('id');
    }
}
