<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/restaurant', [RestaurantController::class, 'index']);
    Route::post('/restaurant', [RestaurantController::class, 'store']);
    Route::get('/restaurant/user', [RestaurantController::class, 'getRestaurant']);
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
});
