<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FrontendController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/blog', 'blog')->name('blog');
});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {

    // ===== Register =====
    Route::get('/register', 'register_page')->name('register');
    Route::post('/register', 'register_method')->name('register.store');

    // ===== Login =====
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login_page'])->name('login');
        Route::post('/login', [AuthController::class, 'login_method'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    // ===== Logout =====
    Route::post('/logout', 'destroy')
        ->middleware('auth')
        ->name('logout');

    // ===== Forgot Password =====
    Route::get('/forgot-password', 'user_forgot_password')
        ->name('user.forgot.password');

    Route::post('/reset-password', 'user_reset_password')
        ->name('user.reset.password');

    Route::get('/update-password/{id}', 'user_update_password')
        ->middleware('signed')
        ->name('user.update.password');

    Route::post('/store-password/{id}', 'user_store_new_password')
        ->name('user.store.password');
});


/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get(
    '/email/verify/{id}/{hash}',
    [AuthController::class, 'verify_register']
)->middleware('signed')->name('verification.verify');


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::controller(DashboardController::class)->group(function () {
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::resource('categories', CategoryController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Error Routes
|--------------------------------------------------------------------------
*/

Route::get('/403', [ErrorController::class, 'error_403'])->name('error.403');
Route::get('/404', [ErrorController::class, 'error_404'])->name('error.404');
