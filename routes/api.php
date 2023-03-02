<?php
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
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/auth', [\App\Http\Controllers\AuthController::class, 'auth']);
Route::get('/tour', [\App\Http\Controllers\FlightController::class, 'searchAirports']);
Route::get('/flight', [\App\Http\Controllers\FlightController::class, 'searchFlights']);
Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'create']);
Route::middleware('auth:api')->group(function () {
    Route::get('/booking/{code}', [\App\Http\Controllers\BookingController::class, 'check']);
    Route::get('/user/booking', [\App\Http\Controllers\BookingController::class, 'checkMy']);
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'self']);
});

