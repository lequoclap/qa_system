<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ship_areas')->insert([
            'name' => str_random(10),
        ]);
        DB::table('ship_areas')->insert([
            'name' => str_random(10),
            'id' => 26
        ]);
    }
}
