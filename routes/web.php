<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

// ===== Frontend Routes =====
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/blog', 'blog')->name('blog');
    Route::post('/login', 'login')->name('login'); // login POST
    Route::post('/register', 'register')->name('register'); // Register POST
});

// ===== Logout Route =====
Route::get('/logout', function () {
    if (FacadesAuth::check()) {
        return redirect()->route('dashboard'); // لو مسجل دخول
    }
    return redirect()->route('login'); // لو مش مسجل دخول
});

// ===== Dashboard/Admin Routes =====
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')
        ->middleware(['auth', 'verified', 'role:admin'])
        ->name('dashboard');
});

require __DIR__ . '/auth.php';