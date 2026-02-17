<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ===== Frontend Routes =====
Route::controller(FrontendController::class)->group(function () {

    Route::get('/', 'index')->name('home');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/blog', 'blog')->name('blog');
});


// ===== Auth =====
Route::controller(AuthController::class)->group(function () {
    // ===== Register & Login =====
    Route::get('register',  action: 'register_page')->name('register');
    Route::post('/register', 'register_method')->name('register'); // Register POST
    Route::get('login', 'login_page')->name('login');
    Route::post('/login', 'login_method')->name('login')
        ->middleware('throttle:5,1'); // login POST

    // ===== Password Forgot & Reset =====
    Route::get('/forgot-password', 'user_forgot_password')
        ->name('user.forgot.password'); // Forgot Password
    Route::post('/reset-password', 'user_reset_password')
        ->name('user.reset.password');  // Reset Password

    Route::post('logout', 'destroy')
        ->name('logout');   // Logout
});



// ===== Dashboard/Admin Routes =====
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')
        ->middleware(['auth', 'verified', 'role:admin'])
        ->name('dashboard');
});

require __DIR__ . '/auth.php';