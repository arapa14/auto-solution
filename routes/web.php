<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
})->name('landing');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/purchase', function () {
    $products = Product::all();
    $orders = [];
    if (auth()->check()) {
        $orders = Order::with('order_products.product')
            ->where('user_id', auth()->id())
            ->get();
    }
    return view('purchase', compact('products', 'orders'));
})->name('purchase');

Route::get('/service', function () {
    return view('service');
})->name('service');

Route::get('/switch/{id}', [AuthController::class, 'switchAccount'])->name('switch-account');
Route::get('/switch-back', [AuthController::class, 'switchBack'])->name('switch-back');

//Route untuk admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin.dashboard');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('admin.products');
    // Menyimpan produk baru (Store)
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    // Update produk yang ada (Update) – gunakan binding model
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    // Hapus produk (Destroy)
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');


    Route::get('/order', function () {
        return view('admin.dashboard');
    })->name('admin.orders');

    Route::get('/services', function () {
        return view('admin.dashboard');
    })->name('admin.services');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/report', function () {
        return view('admin.dashboard');
    })->name('admin.reports');
});

Route::middleware(['auth', 'isUser'])->group(function () {
    // Menampilkan halaman detail produk (form pemesanan)
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

    // Memproses pemesanan produk (form submit)
    Route::post('/product/{id}/order', [ProductController::class, 'order'])->name('product.order');
});
