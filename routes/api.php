<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users',[ApiController::class, 'users']);
Route::get('statistics', [ApiController::class, 'statistics']);

Route::get('userss',[ApiController::class, 'getUsers']);
Route::get('userss/{user}',[ApiController::class, 'getUser']);
Route::post('userss',[ApiController::class, 'createUser']);
Route::delete('userss/{user}',[ApiController::class, 'deleteUser']);

// Route::apiResource('userss',[ApiController::class]);