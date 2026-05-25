<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->getFacultyName(),
            'slug' => $this->getFacultyNameSlug($name),
            'institution_kd' => $this->faker->numberBetween(1, 10000),
            'country_id' => $this->faker->numberBetween(1, 5),
            'dean_id' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function getFacultyName(): string
    {
        return strval("Faculty of {$this->faker->name()}");
    }

    public function getRandomDeanId(): int
    {
        $allDeans = User::where('role', 'dean')->get();
        return $this->faker->numberBetween(1, 5);
    }

    public function getFacultyNameSlug($name): string
    {
        return strval(strtolower(str_replace(' ', '', $name . "-" . Uuid::uuid4())));
    }
}
