<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'renderLogin'])->name('auth.login');
Route::post("/login", [AuthController::class, 'login'])->name('auth.login');

Route::get('/register', [AuthController::class, 'renderRegister'])->name('auth.register');
Route::post("/register", [AuthController::class, 'register'])->name('auth.register');
