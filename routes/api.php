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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//basicAuth
//auth:sanctum
Route::middleware(['basicAuth'])->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/cartView',[\App\Http\Controllers\CartController::class , 'index']);//u
    Route::get('/productView',[\App\Http\Controllers\ProductController::class , 'index']);//u
    Route::post('/productStore',[\App\Http\Controllers\ProductController::class , 'store']);//u
    Route::get('/typeView',[\App\Http\Controllers\TypeController::class , 'index']);//u
    Route::post('/typeStore',[\App\Http\Controllers\TypeController::class , 'store']);//u
    Route::get('/customerView',[\App\Http\Controllers\CustomerController::class , 'index']);//u
    Route::get('/rateView',[\App\Http\Controllers\RateController::class , 'index']);//u
    Route::get('/feedbackView',[\App\Http\Controllers\FeedbackController::class , 'index']);//u
});
//Route::post('/customerStore',[\App\Http\Controllers\CustomerController::class , 'Store']);//c
//Route::post('/orderStore',[\App\Http\Controllers\OrderController::class , 'Store']);//c
//Route::get('/orderCustomerView',[\App\Http\Controllers\CartController::class , 'index2']);//c
//Route::get('/random5',[\App\Http\Controllers\CartController::class , 'random5']);//c
