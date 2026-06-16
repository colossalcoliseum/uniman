<?php

namespace Database\Factories;

use App\Models\Institution;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialty>
 */
class SpecialtyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->randomElement(Specialty::$specialties),
            'slug' => $this->generateSlug($name),
            'institution_id' => Institution::inRandomOrder()->value('id'),
        ];
    }

    public function generateSlug($name): string
    {
        return Str::slug($name.'_'.$this->faker->uuid());
    }
}
