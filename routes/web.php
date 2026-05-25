<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Middleware\ValidateTokenMiddleware;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'renderLogin'])->name('auth.login');
Route::post("/login", [AuthController::class, 'login'])->name('auth.login');

Route::get('/register', [AuthController::class, 'renderRegister'])->name('auth.register');
Route::post("/register", [AuthController::class, 'register'])->name('auth.register');

// Protected routes
Route::middleware(ValidateTokenMiddleware::class)->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
    Route::post('/', [CatalogController::class, 'searchEvent'])->name('catalog.search');
});
