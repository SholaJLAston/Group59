<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = 
        [
            ['name' => 'Power Tools', 'description' => 'Professional power tools for every job', 'image' => 'https://images.unsplash.com/photo-1645651964715-d200ce0939cc'],
            ['name' => 'Hand Tools', 'description' => 'Essential hand tools for DIY and professional use', 'image' => 'https://images.unsplash.com/photo-1567361808960-dec9cb578182'],
            ['name' => 'Safety Equipment', 'description' => 'Keep yourself protected on the job', 'image' => 'https://images.pexels.com/photos/38070/pexels-photo-38070.jpeg'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description'], 'image_url' => $category['image']]
            );  
        }
    }
}
