<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProfileController;

// Public pages (no auth required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Contact form routes (cleaned up – only one GET name)
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated routes (dashboard, profile – you already had these)
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // basket routes
    Route::get('/basket', [BasketController::class, 'index'])->name('basket');
    Route::post('/basket/items/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::patch('/basket/items/{basketItem}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/items/{basketItem}', [BasketController::class, 'remove'])->name('basket.remove');
    Route::delete('/basket', [BasketController::class, 'clear'])->name('basket.clear');

    // product reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');
});

require __DIR__.'/auth.php';