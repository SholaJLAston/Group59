<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatbotController;

// Public pages (no auth required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Contact form routes (cleaned up – only one GET name)
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Site chatbot endpoint (handles product, stock, and order queries)
Route::post('/chatbot/query', [ChatbotController::class, 'query'])
    ->middleware('throttle:20,1')
    ->name('chatbot.query');

// Basket page is visible to guests; actions still require login.
Route::get('/basket', [BasketController::class, 'index'])->name('basket');

// Authenticated routes (dashboard, profile – you already had these)
Route::get('/dashboard', function () {
    if (auth()->user()?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()?->role !== 'admin') {
            return redirect()->route('dashboard');
        }

        return view('home');
    })->name('dashboard');

    Route::get('/settings', [ProfileController::class, 'edit'])
        ->name('settings');
    Route::patch('/settings', [ProfileController::class, 'update'])
        ->name('settings.update');

    // Admin My Orders — shows orders placed by the admin user themselves.
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // basket routes (actions only)
    Route::post('/basket/items/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::patch('/basket/items/{basketItem}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/items/{basketItem}', [BasketController::class, 'remove'])->name('basket.remove');
    Route::delete('/basket', [BasketController::class, 'clear'])->name('basket.clear');

    // customer orders
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');

    // product reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');
});

require __DIR__.'/auth.php';