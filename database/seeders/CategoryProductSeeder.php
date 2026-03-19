<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    private array $categoryProducts = [
        'General Tools'       => ['Screwdriver', 'Hammer', 'Pliers', 'Wrench', 'Saw'],
        'Materials'           => ['Wood', 'Concrete', 'Ceramics', 'Metal', 'Plastic'],
        'Electronic Tools'    => ['Power Drill', 'Wire Stripper', 'Soldering Iron', 'Heat Gun', 'Circular Saw'],
        'Gardening Tools'     => ['Shovel', 'Rake', 'Trowel', 'Shears', 'Lawnmowers'],
        'Electronic Hardware' => ['Resistors', 'Circuits', 'LED', 'Capacitor', 'Electrical Wires & Cables'],
    ];

    public function run(): void
    {
        foreach ($this->categoryProducts as $catName => $products) {
            $category = Category::updateOrCreate(
                ['name' => $catName],
                [
                    'description' => "Products in the $catName category",
                    'image'       => 'images/categories/' . Str::slug($catName) . '.avif',
                ]
            );

            foreach ($products as $prodName) {
                $imagePath = 'images/products/' . Str::slug($catName) . '/' . Str::slug($prodName) . '.avif';

                Product::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name'        => $prodName,
                    ],
                    [
                        'description'    => "High quality $prodName for all your needs.",
                        'price'          => rand(1000, 9999) / 100,
                        'stock_quantity' => rand(0, 20),
                        'image_url'      => $imagePath,
                    ]
                );
            }
        }
    }
}