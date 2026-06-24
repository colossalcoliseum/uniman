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
        User::factory()->admin()->create(['email' => 'admin@admin.com', 'password' => '123123123']);
        User::factory()->rector()->count(5)->create(['password'=>'123123123']);
        User::factory()->dean()->create(['email' => 'dean@uni.com','password'=>'123123123']);

        /* Преподаватели */
        User::factory()->professor()->count(5)->create(['password' => '123123123']);
        User::factory()->associateProfessor()->count(15)->create(['password' => '123123123']);
        User::factory()->assistant()->count(20)->create(['password' => '123123123']);

        /* Студенти */
        User::factory()->student()->count(50)->create(['password' => '123123123']);

    }
}
