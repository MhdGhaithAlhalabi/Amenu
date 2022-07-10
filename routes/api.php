<?php

use App\Http\Controllers\Authadmin;
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
//header("Access-Control-Allow-Origin: http://localhost:3000");
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::get('usersView', [Authadmin::class, 'usersView']);
    Route::post('usersDelete/{id}', [Authadmin::class, 'usersDelete']);
    Route::post('usersEdit/{id}', [Authadmin::class, 'usersEdit']);
    Route::post('createRestaurant', [Authadmin::class, 'createRestaurant']);

});
Route::middleware(['auth:sanctum', 'abilities:user'])->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/cartGoing/{id}',[\App\Http\Controllers\CartController::class , 'cartGoing']);//react
    Route::post('/cartDone/{id}',[\App\Http\Controllers\CartController::class , 'cartDone']);//react
    Route::get('/cartView',[\App\Http\Controllers\CartController::class , 'index']);//react
    Route::get('/cartGoingView',[\App\Http\Controllers\CartController::class , 'cartGoingView']);//react
    Route::get('/cartDoneView',[\App\Http\Controllers\CartController::class , 'cartDoneView']);//react
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
    Route::get('/feedbackReadView',[\App\Http\Controllers\FeedbackController::class , 'index2']);//react
    Route::post('/feedbackRead/{id}',[\App\Http\Controllers\FeedbackController::class , 'feedbackRead']);//react
    Route::get('/dailyReport',[\App\Http\Controllers\CartController::class , 'dailyReport']);//react
    Route::get('/monthlyReport',[\App\Http\Controllers\CartController::class , 'monthlyReport']);//react
    Route::get('/outOfMenu',[\App\Http\Controllers\MenuController::class , 'outOfMenu']);//react
    Route::post('/menuStore',[\App\Http\Controllers\MenuController::class , 'store']);//react
    Route::delete('/menuDelete/{id}',[\App\Http\Controllers\MenuController::class , 'destroy']);//react
    Route::get('/Menu',[\App\Http\Controllers\MenuController::class , 'index']);//react

    //inMenu

});
Route::post('/customerStore',[\App\Http\Controllers\CustomerController::class , 'Store']);//flutter
Route::post('/orderStore',[\App\Http\Controllers\OrderController::class , 'Store']);//flutter
Route::post('/testList',[\App\Http\Controllers\OrderController::class , 'testList']);//flutter
Route::get('/orderCustomerView/{customer_id}',[\App\Http\Controllers\CartController::class , 'index2']);//flutter
Route::post('/feedbackStore',[\App\Http\Controllers\FeedbackController::class , 'store']);//flutter
Route::get('/rateView/{id}',[\App\Http\Controllers\RateController::class , 'show']);//flutter
Route::post('/rateStore',[\App\Http\Controllers\RateController::class , 'store']);//flutter
Route::get('/random5/{customer_id}',[\App\Http\Controllers\CartController::class , 'random5']);//flutter

