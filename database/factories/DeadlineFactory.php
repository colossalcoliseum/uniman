<?php

namespace Database\Factories;

use App\Enums\TermPaperStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deadline>
 */
class DeadlineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'term_paper_id' => $this->faker->numberBetween(1, 10000),
            'end_date' => $this->faker->dateTimeBetween('-5 weeks', '5 weeks'),
            'type' => self::randomTermPaperStatus(),
            'description' => $this->faker->paragraph(),
        ];
    }

    public static function randomTermPaperStatus()
    {
        return array_rand(TermPaperStatus::cases()[array_rand(TermPaperStatus::cases())]);
    }
}
