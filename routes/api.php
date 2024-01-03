<?php

use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[RatingController::class,'registerUser']);
Route::post('/login',[RatingController::class,'loginUser']);
Route::post('/saveRating',[RatingController::class,'saveRating']);
Route::post('/updateRating/{id}',[RatingController::class,'updateServiceRating']);
Route::get('/deleteRating/{id}',[RatingController::class,'deleteServiceRating']);
Route::get('/showRating',[RatingController::class,'showServiceRating']);
Route::get('/editRating/{id}',[RatingController::class,'editServiceRating']);








