<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a Faker instance
        $faker = Faker::create();

        $products = [];

        // Generate 20 random products
        for ($i = 0; $i < 20; $i++) {
            $products[] = [
                'name' => $faker->word, // Random product name
                'description' => $faker->sentence, // Random product description
                'price' => $faker->randomFloat(2, 10, 500), // Random price between 10 and 500
                'status' => $faker->randomElement(['available', 'out of stock']), // Random status
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data into the products table
        DB::table('products')->insert($products);
    }
}
