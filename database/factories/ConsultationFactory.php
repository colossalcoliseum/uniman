<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'term_paper_id' => TermPaper::inRandomOrder()->value('id'),
            'teacher_id' => User::where('type', UserType::TEACHER->value)->inRandomOrder()->value('id'),
            'student_id' => User::where('type', UserType::STUDENT->value)->inRandomOrder()->value('id'),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+2 months'),
            'type' => $this->faker->randomElement(['online', 'in_person']),
        ];
    }
}
