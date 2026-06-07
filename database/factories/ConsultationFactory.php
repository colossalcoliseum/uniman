<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

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
            'term_paper_id' => $this->faker->numberBetween(1, 100),
            'teacher_id' => $this->faker->numberBetween(1, 100),
            'student_id' => $this->getUniqueStudentId($this->faker->numberBetween(1, 10000)),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+2 months'),
            'type' => $this->faker->randomElement(['online', 'in_person']),
        ];
    }
    public function getRandomConsultationType(){

    }
    public function getUniqueStudentId(int $id): int
    {

        if ($this->isDuplicate($id)) {
            return $this->generateDifferentId($id);
        }
        return $this->addStudentIdToCache($id);
    }

    public function addStudentIdToCache($Id)
    {
        $usedIds = Cache::get('studentIds', []);
        $usedIds[] = $Id;
        Cache::store('database')->put('studentIds', $usedIds, now()->addMinutes(5));

        return $Id;
    }

    /*
     * Проверка за вече използвани ид
     * */
    public function isDuplicate($Id): bool
    {
        $allStudentIds = Cache::get('studentIds', []);
        return in_array($Id, $allStudentIds);
    }

    public function generateDifferentId($Id): int
    {
        $allStudentIds = Cache::get('studentIds', []);
        while (in_array($Id, $allStudentIds)) {
            $Id = $this->faker->numberBetween(1, 10000);
        }
        return $this->addStudentIdToCache($Id);
    }


}
