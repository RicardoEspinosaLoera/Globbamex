<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stripe = new StripeClient(config('cashier.secret'));

        $product = $stripe->products->create(['name' => 'Plan Básico']);
        $price = $stripe->prices->create(['currency' => 'usd', 'unit_amount' => 1000, 'recurring' => ['interval' => 'month'], 'product' => $product->id]);

        DB::table('plans')->insert([
            'id' => 1,
            'name' => 'Plan Básico',
            'price' => 10.00,
            'duration' => 1,
            'description' => NULL,
            'subscription_api_id' => $price->id,
            'sales_commission' => 20,
            'state' => '1'
        ]);

        $product = $stripe->products->create(['name' => 'Plan Medio']);
        $price = $stripe->prices->create(['currency' => 'usd', 'unit_amount' => 2000, 'recurring' => ['interval' => 'month'], 'product' => $product->id]);

        DB::table('plans')->insert([
            'id' => 2,
            'name' => 'Plan Medio',
            'price' => 20.00,
            'duration' => 1,
            'description' => NULL,
            'subscription_api_id' => $price->id,
            'sales_commission' => 15,
            'state' => '1'
        ]);

        $product = $stripe->products->create(['name' => 'Plan Profesional']);
        $price = $stripe->prices->create(['currency' => 'usd', 'unit_amount' => 3000, 'recurring' => ['interval' => 'month'], 'product' => $product->id]);

        DB::table('plans')->insert([
            'id' => 3,
            'name' => 'Plan Profesional',
            'price' => 30.00,
            'duration' => 1,
            'description' => NULL,
            'subscription_api_id' => $price->id,
            'sales_commission' => 10,
            'state' => '1'
        ]);
    }
}
