<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
})->name('landing');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/purchase', function() {
    $products = Product::all();
    return view('purchase', compact('products'));
})->name('purchase');

Route::get('/sale', function() {
    return view('sale');
})->name('sale');

Route::get('/service', function() {
    return view('service');
})->name('service');

//Route untuk admin
Route::middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/admin', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'isUser'])->group(function() {
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
});