<?php

use Illuminate\Database\Seeder;

class ShippingDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_durations')->insert([
            'name' => str_random(10),
            'min_days' => 1,
            'max_days' => 1,
            'id' => 1
        ]);
        DB::table('shipping_methods')->insert([
            'name' => str_random(10),
            'id' => 1
        ]);
        DB::table('shipping_methods')->insert([
            'name' => str_random(10),
            'id' => 2
        ]);
        DB::table('shipping_methods')->insert([
            'name' => str_random(10),
            'id' => 5
        ]);
        DB::table('shipping_payers')->insert([
            'name' => str_random(10),
            'id' => 1
        ]);
    }
}
