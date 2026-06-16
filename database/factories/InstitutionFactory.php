<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->generateUniqueUniversityName(),
            'slug' => $this->generateSlug($name),
            'type' => 'University',
            'country_id' => Country::inRandomOrder()->value('id'),
            'description' => $this->faker->realText(),
            'manager_id' => User::where('role', UserRole::RECTOR->value)
                ->inRandomOrder()
                ->value('id'),
        ];
    }

    private function generateUniqueUniversityName(): string
    {
        $universityTypes = [
            'Technical University',
            'University of Biotechnology',
            'Mechanical University',
            'Research University',
            'International University',
            'Private University',
            'Public University',
        ];

        return $universityTypes[array_rand($universityTypes)].' of '.$this->faker->country();
    }

    private function generateSlug($name): string
    {
        return Str::slug($name.'-'.$this->faker->uuid());
    }
}
