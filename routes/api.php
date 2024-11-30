<?php

use App\Http\Controllers\Apis\v1\BidController;
use App\Http\Controllers\Apis\v1\TaskController;
use App\Http\Controllers\Auth\Driver\RegisterController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\User\LoginRegisterController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(CityController::class)->group(function () {
    Route::post('get-cities-based-on-state', 'getCititesBasedOnState')->name('city.getCitiesBasedOnState');
});

Route::controller(TaskController::class)->group(function () {
    // Route::post('send-task', 'createTask');
    // Route::post('update-task', 'updateTask');
    Route::get('get-task-by-id/{id}', 'getTaskById');
    Route::get('get-all-task', 'getAllTask');
    Route::get('get-all-task-listing', 'getAllTaskListing');

    // Route::get('task-galleries/{task_id}', 'getTaskGallery');
    // Route::delete('delete-task/{id}', 'deleteTask');
    // Route::get('is-card-add', 'checkStripeCard');
    // Route::get('all-jobs-listing', 'getAllTaskList');
    // Route::get('current-job', 'currentJOb');
    // Route::get('job-histories', 'jobHistories');
});

Route::controller(StateController::class)->group(function () {
    Route::get('get-states', 'getStates');
});

Route::middleware('auth:recruiter')->group(function () {
    Route::post('jobPosts', [JobPostController::class, 'store']);
    });
    

Route::controller(TaskController::class)->group(function () {
    // Route::post('send-task', 'createTask');
    // Route::post('update-task', 'updateTask');
    // Route::get('get-task-by-id/{id}', 'getTaskById');
    Route::get('get-all-task/{id}', 'getAllTask');
    Route::get('get-all-task-listing', 'getAllTaskListing');

    // Route::get('task-galleries/{task_id}', 'getTaskGallery');
    // Route::delete('delete-task/{id}', 'deleteTask');
    // Route::get('is-card-add', 'checkStripeCard');
    Route::get('all-jobs-listing', 'getAllTaskList');
    // Route::get('current-job', 'currentJOb');
    // Route::get('job-histories', 'jobHistories');
});

// User Auth
Route::get('get-job-detail/{id}', [TaskController::class, 'getDetailJob'])->withoutMiddleware(['auth:api']);

Route::prefix('bids')->controller(BidController::class)->group(function () {
    Route::get('all/{task_id}', 'getAllBids');
    Route::post('accept-bid-request', 'userAcceptBid');
    Route::post('bid-request-cancel', 'userCanceledBidRequest');
    Route::post('bidding', 'bidding');
    Route::delete('delete/{id}', 'deleteBid');
});

Route::controller(UserAuthController::class)->group(function () {
    Route::post('logout', 'logout');
    Route::post('update-fcm', 'updateFcmToken');
});

Route::post('recruiter/post-login', [LoginRegisterController::class, 'login'])->name('recruiterLogin.post');
Route::post('driver/post-login', [LoginRegisterController::class, 'Driverlogin'])->name('DriverLogin.post');
Route::post('recruiter/register-post', [LoginRegisterController::class, 'registration']);
Route::post('/driver/register', [RegisterController::class, 'register'])->name('driver.register');
