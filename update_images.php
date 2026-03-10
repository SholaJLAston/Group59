<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

// Update Electronic Tools products
Product::where('name', 'Power Drill')->update(['image_url' => 'images/products photo/Electronicpower tools/Power Drill.avif']);
Product::where('name', 'Wire Stripper')->update(['image_url' => 'images/products photo/Electronicpower tools/Wire stripper.avif']);
Product::where('name', 'Soldering Iron')->update(['image_url' => 'images/products photo/Electronicpower tools/Soldering Iron.avif']);
Product::where('name', 'Heat Gun')->update(['image_url' => 'images/products photo/Electronicpower tools/Heat gun,.avif']);
Product::where('name', 'Circular Saw')->update(['image_url' => 'images/products photo/Electronicpower tools/Power Saw (Circular Saw).avif']);

echo "✓ Updated 5 Electronic Tools products\n";
