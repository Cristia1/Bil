<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Customer;
use Faker\Factory as Faker;

class SedersInv extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $user = User::first();

        for ($i = 0; $i < 500; $i++) {
            $customer = Customer::inRandomOrder()->first();

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'invoice_number' => $faker->randomNumber(),
                'due_date' => $faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
                'payment_term' => $faker->randomElement(['7', '12', '14']),
                'currency' => $faker->randomElement(['Ron', 'Eur', 'Usd']),
                'type' => 'general',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'amount' => $faker->randomFloat(2, 10, 1000),
                'description' => $faker->sentence,
            ]);
        }
    }
}
