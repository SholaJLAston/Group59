<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create a test user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);

        // product categories with five items each
        $categoryProducts = [
            'General Tools' => ['Screwdriver', 'Hammer', 'Pliers', 'Wrench', 'Saw'],
            'Materials' => ['Wood', 'Concrete', 'Soil', 'Metal', 'Plastic'],
            'Electronic Tools' => ['Power Drill', 'Wire Stripper', 'Soldering Iron', 'Heat Gun', 'Circular Saw'],
            'Gardening Tools' => ['Shovel', 'Rake', 'Trowel', 'Shears', 'Hoe'],
            'Electronic Hardware' => ['Resistors', 'Circuits', 'LED', 'Capacitor', 'Transistor'],
        ];

        foreach ($categoryProducts as $catName => $products) {
            $category = \App\Models\Category::firstOrCreate(
                ['name' => $catName],
                ['description' => "Products in the $catName category"]
            );

            foreach ($products as $prodName) {
                \App\Models\Product::firstOrCreate([
                    'category_id' => $category->id,
                    'name' => $prodName,
                ], [
                    'description' => "High quality $prodName for all your needs.",
                    'price' => rand(1000, 9999) / 100,
                    'stock_quantity' => rand(0, 20),
                    'image_url' => 'images/products photo/' . \Illuminate\Support\Str::slug($catName) . '/' . \Illuminate\Support\Str::slug($prodName) . '.avif',
                ]);
            }
        }
        }
    }
