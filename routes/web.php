<?php

use App\Http\Controllers\Apis\v1\TaskController;
use App\Http\Controllers\Auth\Driver\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LoginRegisterController;
use App\Http\Controllers\Web\TaskController as WebTaskController;
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
Route::middleware('auth:recruiter')->group(function () {
    Route::get('jobPosts/create', [JobPostController::class, 'create']);
    Route::get('jobPosts', [JobPostController::class, 'index']);
    });

Route::controller(WebTaskController::class)->group(function(){
    Route::get('jobListing', 'joblistingComponent');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::controller(TaskController::class)->group(function () {
Route::get('get-task-by-id/{id}', 'getTaskById');
});

Route::get('recruiter/login', [LoginRegisterController::class, 'showLoginForm'])->name('recruiter.login');
Route::get('driver/login', [LoginRegisterController::class, 'driverLoginForm'])->name('driver.login');

Route::get('recruiter/register', [LoginRegisterController::class, 'register'])->name('recruiter/register');

Route::get('/driver/registeration', [RegisterController::class, 'showRegistrationForm'])->name('driver.registerForm');


Route::get('/recruiter/verify/{token}', [LoginRegisterController::class, 'verifyRecruiterEmail'])->name('peer/verify');

Route::fallback(function () {
    return view('webPages.notFound'); // Make sure the view exists in resources/views/errors/404.blade.php
});
