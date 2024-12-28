<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LatestWorkController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactUsController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactUsController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactUsController::class, 'send'])->name('contact.send');
// Services Page Route
Route::get('/services', function () {
    return view('services');
})->name('services');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Show login form
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');

    // Handle login submission
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Handle logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    // Protected Routes (e.g., Dashboard)
    Route::middleware([AuthMiddleware::class])->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index'); // List services
        Route::get('/services/create', [ServiceController::class, 'create'])->name('admin.services.create'); // Show create form
        Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store'); // Store service
        Route::put('/services/{id}', [ServiceController::class, 'update'])->name('admin.services.update'); // Update service
        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('admin.services.destroy'); // Delete service

        Route::get('/latest-works', [LatestWorkController::class, 'index'])->name('admin.latest-works.index'); // List latest works
        Route::get('/latest-works/create', [LatestWorkController::class, 'create'])->name('admin.latest-works.create'); // Show create form
        Route::post('/latest-works', [LatestWorkController::class, 'store'])->name('admin.latest-works.store'); // Store latest work
        Route::put('/latest-works/{id}', [LatestWorkController::class, 'update'])->name('admin.latest-works.update'); // Update latest work
        Route::delete('/latest-works/{id}', [LatestWorkController::class, 'destroy'])->name('admin.latest-works.destroy'); // Delete latest work
    

        

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});
