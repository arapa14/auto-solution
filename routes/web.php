<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
})->name('landing');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route untuk admin
Route::middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/admin', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});