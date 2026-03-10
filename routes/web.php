<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/basket/products/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::patch('/basket/items/{basketItem}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/items/{basketItem}', [BasketController::class, 'remove'])->name('basket.remove');
    Route::delete('/basket', [BasketController::class, 'clear'])->name('basket.clear');
});

require __DIR__.'/auth.php';
