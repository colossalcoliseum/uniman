<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/*използвай array_rand директно от countries.php*/

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
            'slug' => $this->getInstitutionNameSlug($name),
            'type' => 'University',
            'country_id' => array_rand(Country::$countries),
            'description' => $this->faker->realText(),
            'manager_id' => $this->faker->randomElement($this->getAllTeachers()), // TODO: или по роля т.е. да е проф. или доц чрез randomElement
        ];
    }

    public function generateUniqueUniversityName(): string
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

        return $universityTypes[array_rand($universityTypes)] . ' of ' . $this->faker->country();
    }

    public function getAllTeachers(): array
    {
        return once(function () {
            return User::ofType('teacher')->pluck('id')->toArray();
        });
    }

    public function getInstitutionNameSlug($name): string
    {
        return strtolower(str_replace(' ', '', $name . "-" . Uuid::uuid4()));
    }
}
