<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin account for initial access.
        $admin = User::firstOrCreate(
            ['email' => 'admin@apexhardware.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone_number' => '+1 (555) 123-4567',
                'role' => 'admin',
                'password' => Hash::make('Admin@12345'),
                'email_verified_at' => now(),
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }

        // Create a default customer test account.
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'phone_number' => null,
                'role' => 'customer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

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
