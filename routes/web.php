<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\ValidateTokenMiddleware;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'renderLogin'])->name('auth.login.form');
Route::post("/login", [AuthController::class, 'login'])->name('auth.login');

//Route::get('/register', [AuthController::class, 'renderRegister'])->name('auth.register');
//Route::post("/register", [AuthController::class, 'register'])->name('auth.register');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Protected routes
Route::middleware(ValidateTokenMiddleware::class)->group(function () {
    // Events
    Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');

    // Unique event
    Route::get('/event/{id}', [EventController::class, 'index'])->name('event.index');

    // Seats
    Route::get('/event/showtime/{id}', [EventController::class, 'displaySeats'])->name('event.display-seats');
    Route::post('/event/showtime/{id}', [EventController::class, 'buySeats'])->name('event.buy-seats');
});
