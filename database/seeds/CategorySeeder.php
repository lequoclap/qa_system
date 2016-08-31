<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => "Technology"
        ]);
        DB::table('categories')->insert([
            'name' => "Science"
        ]);

        DB::table('categories')->insert([
            'name' => "Business"
        ]);

        DB::table('categories')->insert([
            'name' => "Life"
        ]);

        DB::table('categories')->insert([
            'name' => "Management"
        ]);

        DB::table('categories')->insert([
            'name' => "Communication"
        ]);

        DB::table('categories')->insert([
            'name' => "Manner"
        ]);

        DB::table('categories')->insert([
            'name' => "Other"
        ]);

    }
}