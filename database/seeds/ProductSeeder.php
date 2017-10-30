<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < mt_rand(50, 200); $i++) {
            DB::table('products')->insert([
                'title' => str_random(10),
                'preview' => str_random(10),
                'price' => mt_rand(1, 1000),
                'description' => str_random(100)
            ]);
        }
    }
}
