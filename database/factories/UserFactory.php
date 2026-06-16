<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::STUDENT->value,
            'handle' => fake()->unique()->userName(),
            'type' => UserType::STUDENT->value,
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }

    public function dean(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::DEAN->value,
            'type' => UserType::TEACHER->value,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ADMIN->value,
            'type' => null,
        ]);
    }

    public function rector(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::RECTOR->value,
            'type' => UserType::TEACHER->value,
        ]);
    }

    public function professor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::PROFESSOR->value,
            'type' => UserType::TEACHER->value,
        ]);
    }

    public function assistant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ASSISTANT->value,
            'type' => UserType::TEACHER->value,
        ]);
    }

    public function associateProfessor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ASSOCIATE_PROFESSOR->value,
            'type' => UserType::TEACHER->value,
        ]);
    }
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::STUDENT->value,
            'type' => UserType::STUDENT->value,
        ]);
    }
}
