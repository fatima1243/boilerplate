<?php

use App\Http\Controllers\Auth\Driver\RegisterController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
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

Route::controller(StateController::class)->group(function () {
    Route::get('get-states', 'getStates');
});
