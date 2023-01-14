<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get data from the json file that has all the countries with all the data for country
        $json = File::get("database/data/countries.json");

        // Decode the json data to access the objects
        $countries = json_decode($json);

        // Loop through the data
        foreach ($countries as $key => $value) {
            $saveCountry = [
                [
                    'id' => $value->id,
                    'name' => $value->name,
                    'slug' => $value->slug,
                    'data' => json_encode($value->data),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];

            // store
            DB::table((new Country())->getTable())->insert($saveCountry);
        }
    }
}
