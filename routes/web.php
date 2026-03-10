<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;

// Public pages (no auth required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Unified Account page (login + register in one page – your custom design)
Route::get('/account', [AccountController::class, 'index'])->name('account');

// Redirect default Laravel /login and /register to your custom unified page
Route::get('/login', fn() => redirect()->route('account'))->name('login');
Route::get('/register', fn() => redirect()->route('account'))->name('register');

// Cart / Basket page (required by brief)
Route::get('/basket', function () {
    return view('pages.basket');
})->name('basket');

// Contact form routes (cleaned up – only one GET name)
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated routes (dashboard, profile – you already had these)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // product reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');
});

require __DIR__.'/auth.php';