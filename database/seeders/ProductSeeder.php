<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Level;
use Faker\Factory as Faker;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level = Level::all();
        $faker = Faker::create();
        foreach ($level as $item) {
            // for ($i = 0; $i < 2; $i++) {
                Product::create([
                    'name' => $faker->name,
                    'level_id' => $item->id,
                    'price' => $faker->numberBetween(0, $item->min_balance),
                    'description' => $faker->text,
                    'image' => $faker->imageUrl(640, 480, 'products', true),
                ]);
            // }
        }
    }
}
