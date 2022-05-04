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

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/cartView',[\App\Http\Controllers\CartController::class , 'index']);//react
    Route::get('/productView',[\App\Http\Controllers\ProductController::class , 'index']);//react
    Route::post('/productStore',[\App\Http\Controllers\ProductController::class , 'store']);//react
    Route::post('/productEdit/{id}',[\App\Http\Controllers\ProductController::class , 'update']);//react
    Route::delete('/productDelete/{id}',[\App\Http\Controllers\ProductController::class , 'destroy']);//react
    Route::get('/typeView',[\App\Http\Controllers\TypeController::class , 'index']);//react
    Route::post('/typeStore',[\App\Http\Controllers\TypeController::class , 'store']);//react
    Route::post('/typeEdit/{id}',[\App\Http\Controllers\TypeController::class , 'update']);//react
    Route::delete('/typeDelete/{id}',[\App\Http\Controllers\TypeController::class , 'destroy']);//react
    Route::get('/customerView',[\App\Http\Controllers\CustomerController::class , 'index']);//react
    Route::get('/rateView',[\App\Http\Controllers\RateController::class , 'index']);//react
    Route::get('/rateCustomView/{id}',[\App\Http\Controllers\RateController::class , 'show']);//react
    Route::get('/feedbackView',[\App\Http\Controllers\FeedbackController::class , 'index']);//react
});
    Route::post('/customerStore',[\App\Http\Controllers\CustomerController::class , 'Store']);//flutter
    Route::post('/orderStore',[\App\Http\Controllers\OrderController::class , 'Store']);//flutter
    Route::get('/orderCustomerView/{customer_id}',[\App\Http\Controllers\CartController::class , 'index2']);//flutter
    Route::post('/feedbackStore',[\App\Http\Controllers\FeedbackController::class , 'store']);//flutter
    Route::get('/rateView/{id}',[\App\Http\Controllers\RateController::class , 'show']);//flutter
    Route::post('/rateStore',[\App\Http\Controllers\RateController::class , 'store']);//flutter
    Route::get('/random5/{customer_id}',[\App\Http\Controllers\CartController::class , 'random5']);//flutter

