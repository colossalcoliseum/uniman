<?php

namespace Database\Factories;

use App\Enums\TermPaperStatus;
use App\Enums\UserType;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TermPaper>
 */
class TermPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->generateThesisName(),
            'slug' => $this->generateThesisSlug($name),
            'teacher_id' => User::ofType(UserType::TEACHER->value)->inRandomOrder()->value('id'),
            'student_id' => User::ofType(UserType::STUDENT->value)->inRandomOrder()->value('id'),
            'start_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'status' => $this->faker->randomElement(TermPaperStatus::cases()),
            'remark_id' => \App\Models\Remark::inRandomOrder()->value('id'),

        ];
    }

    public function generateThesisName(): string
    {
        $action = $this->faker->randomElement(TermPaper::$actions);
        $domain = $this->faker->randomElement(TermPaper::$domains);
        if ($this->faker->boolean(60)) {
            return "{$action} of {$domain} {$action}";
        }

        return "{$action} of {$domain}";
    }

    public function generateThesisSlug($name): string
    {
        return Str::slug($name.'_'.$this->faker->uuid());
    }
}
