<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\Faculty;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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
            'institution_id' => Institution::inRandomOrder()->value('id'),
            'country_id' => Country::inRandomOrder()->value('id'),
            'dean_id' => User::where('role', UserRole::DEAN->value)
                ->inRandomOrder()
                ->value('id'),
        ];
    }

    public function getFacultyName(): string
    {
        return "Faculty of {$this->faker->randomElement(Faculty::$faculties)}";
    }

    private array $usedDeanIds = [];

    private function getRandomDeanId(): int
    {
        $deanId = User::where('role', UserRole::DEAN->value)
            ->whereNotIn('id', $this->usedDeanIds)
            ->inRandomOrder()
            ->value('id');

        $this->usedDeanIds[] = $deanId;

        return $deanId;
    }

    public function getFacultyNameSlug($name): string
    {
        return strtolower(str_replace(' ', '', $name.'-'.Uuid::uuid4()));
    }
}
