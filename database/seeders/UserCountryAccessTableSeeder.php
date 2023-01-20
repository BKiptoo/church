<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use App\Models\UserCountryAccess;
use Illuminate\Database\Seeder;

class UserCountryAccessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get user
        $user = User::query()->first();

        // loop through
        foreach (Country::query()->inRandomOrder()->limit(10)->get() as $country) {
            UserCountryAccess::query()->create([
                'user_id' => $user->id,
                'country_id' => $country->id
            ]);
        }
    }
}
