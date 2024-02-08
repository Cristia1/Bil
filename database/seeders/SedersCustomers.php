<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use Faker\Factory as Faker;

class SedersCustomers extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $user = User::first();

        for ($i = 0; $i < 500; $i++) {
            Customer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'contact_name' => $faker->name,
                    'company_name' => $faker->company,
                    'email' => $faker->email,
                    'vat_number' => $faker->randomNumber(9),
                ],
                [
                    'status' => $faker->randomElement(['active', 'inactive']),
                    'type' => $faker->randomElement(['individual', 'business']),
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                ]
            );
        }
    }
}

