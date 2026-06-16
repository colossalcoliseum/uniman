<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Единични записи */
        User::factory()->admin()->create(['email' => 'admin@admin.com']);
        User::factory()->rector()->count(5)->create();
        User::factory()->dean()->create(['email' => 'dean@uni.com']);

        /* Преподаватели */
        User::factory()->professor()->count(5)->create();
        User::factory()->associateProfessor()->count(15)->create();
        User::factory()->assistant()->count(20)->create();

        /* Студенти */
        User::factory()->student()->count(50)->create();

    }
}
