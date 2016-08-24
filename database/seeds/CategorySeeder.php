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
        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 1,
            'root_category_id' => 1,
            'brand_group_id' => 1,
        ]);
        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 1,
            'root_category_id' => 1,
            'brand_group_id' => 1,
            'id' => 5
        ]);

        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 2,
            'root_category_id' => 2,
            'brand_group_id' => 2,
            'id' => 226
        ]);
        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 2,
            'root_category_id' => 2,
            'brand_group_id' => 2,
            'id' => 236
        ]);
        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 2,
            'root_category_id' => 2,
            'brand_group_id' => 2,
            'id' => 986
        ]);
        DB::table('item_categories')->insert([
            'name' => str_random(10),
            'parent_category_id' => 2,
            'root_category_id' => 2,
            'brand_group_id' => 2,
            'id' => 864
        ]);
    }
}