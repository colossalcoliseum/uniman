<?php

namespace Database\Factories;

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
        return [
            'title' => $this->faker->sentence(5),
            /*TODO: да връща резултат тип 'recension of {име на дипломна работа}' -> без повтарящи се имена на дипломни работи
            ->кеширане + проверка за дубликати
            */
        ];
    }
}
