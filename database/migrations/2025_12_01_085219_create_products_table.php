<?php

// WARNING: Do NOT run this migration on the server yet. Still subject to tests.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name')->index();
            $table->text('description');
            $table->decimal('price', 8, 2)->index();
            $table->unsignedInteger('stock_quantity');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
