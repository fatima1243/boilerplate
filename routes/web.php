<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Custom login route for admin
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);

// Logout route
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

//Home Page
// Route::post('/', [LoginController::class, 'logout'])->name('admin.logout');

// Authenticated routes
Route::group(['middleware' => 'auth'], function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::fallback(function () {
    return view('webPages.notFound'); // Make sure the view exists in resources/views/errors/404.blade.php
});
