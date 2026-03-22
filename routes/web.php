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
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

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

// Authenticated routes 
Route::get('/dashboard', function () {
    if (auth()->user()?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return app(HomeController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin', 'password.changed'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminInventoryController::class, 'dashboard'])->name('dashboard');

    Route::get('/settings', [ProfileController::class, 'edit'])
        ->name('settings');
    Route::patch('/settings', [ProfileController::class, 'update'])
        ->name('settings.update');

    // Admin order management (customer transactions and shipments)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('orders.search');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/process', [AdminOrderController::class, 'processIncoming'])->name('orders.process');

    // Admin customer management
    Route::get('/customers', [AdminUserController::class, 'index'])->name('customers.index');
    Route::get('/customers/{user}', [AdminUserController::class, 'show'])->name('customers.show');
    Route::get('/customers/{user}/edit', [AdminUserController::class, 'edit'])->name('customers.edit');
    Route::patch('/customers/{user}', [AdminUserController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{user}', [AdminUserController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{user}/activity', [AdminUserController::class, 'viewActivity'])->name('customers.activity');
    Route::get('/customers/{user}/orders', [AdminUserController::class, 'viewOrders'])->name('customers.orders');

    // Customer messages from contact form
    Route::get('/messages', [AdminUserController::class, 'messages'])->name('messages.index');
    Route::patch('/messages/{message}/status', [AdminUserController::class, 'updateMessageStatus'])->name('messages.status');

    // Admin product and inventory CRUD
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{product}/stock', [AdminProductController::class, 'manageStock'])->name('products.stock');
    Route::patch('/products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock.update');

    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/incoming', [AdminInventoryController::class, 'createIncoming'])->name('inventory.incoming.create');
    Route::post('/inventory/incoming', [AdminInventoryController::class, 'storeIncoming'])->name('inventory.incoming.store');
    Route::get('/inventory/movements', [AdminInventoryController::class, 'movements'])->name('inventory.movements');
    Route::get('/inventory/alerts', [AdminInventoryController::class, 'lowStockAlerts'])->name('inventory.alerts');
    Route::patch('/inventory/products/{product}/threshold', [AdminInventoryController::class, 'updateThreshold'])->name('inventory.threshold.update');
    Route::get('/inventory/products/{product}', [AdminInventoryController::class, 'viewProduct'])->name('inventory.products.show');

    // Real-time reports
    Route::get('/reports/stock-levels', [AdminReportController::class, 'stockLevels'])->name('reports.stock-levels');
    Route::get('/reports/incoming-orders', [AdminReportController::class, 'incomingOrders'])->name('reports.incoming-orders');
    Route::get('/reports/outgoing-orders', [AdminReportController::class, 'outgoingOrders'])->name('reports.outgoing-orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // basket routes (actions only)
    Route::post('/basket/items/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::patch('/basket/items/{basketItem}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/items/{basketItem}', [BasketController::class, 'remove'])->name('basket.remove');
    Route::delete('/basket', [BasketController::class, 'clear'])->name('basket.clear');

    // checkout flow
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

    // customer orders
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    // product reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');
});

require __DIR__.'/auth.php';