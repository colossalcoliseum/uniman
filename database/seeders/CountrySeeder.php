<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Country::$countries as $countryCode => $countryName) {
            Country::create([
                'name' => $countryName,
                'slug' => Str::slug($countryName),
                'code' => $countryCode,
            ]);
        }
    }
}
