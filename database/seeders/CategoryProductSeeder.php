<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    /**
     * Maps category name => actual folder name under public/images/products photo/
     * Folder names must match exactly what exists on disk.
     */
    private array $categoryFolders = [
        'General Tools'       => 'General Tools',
        'Materials'           => 'Materials',
        'Electronic Tools'    => 'Electronicpower tools', 
        'Gardening Tools'     => 'Gardening Tools',
        'Electronic Hardware' => 'Electronic Hardware',
    ];

    private array $categoryProducts = [
        'General Tools'       => ['Screwdriver', 'Hammer', 'Pliers', 'Wrench', 'Saw'],
        'Materials'           => ['Wood', 'Concrete', 'Soil', 'Metal', 'Plastic'],
        'Electronic Tools'    => ['Power Drill', 'Wire Stripper', 'Soldering Iron', 'Heat Gun', 'Circular Saw'],
        'Gardening Tools'     => ['Shovel', 'Rake', 'Trowel', 'Shears', 'Hoe'],
        'Electronic Hardware' => ['Resistors', 'Circuits', 'LED', 'Capacitor', 'Transistor'],
    ];

    public function run(): void
    {
        foreach ($this->categoryProducts as $catName => $products) {
            $category = Category::firstOrCreate(
                ['name' => $catName],
                ['description' => "Products in the $catName category"]
            );

            $folder = $this->categoryFolders[$catName];

            foreach ($products as $prodName) {
                $imagePath = 'images/products photo/' . $folder . '/' . Str::slug($prodName) . '.avif';

                Product::firstOrCreate(
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