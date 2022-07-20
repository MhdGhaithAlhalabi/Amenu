<?php

use App\Http\Controllers\Authadmin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\TypeController;
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

//////////////////////////react api////////////////////////
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    //ADMIN CONTROLLER
    Route::get('usersView', [Authadmin::class, 'usersView']);
    Route::post('usersDelete/{id}', [Authadmin::class, 'usersDelete']);
    Route::post('usersEdit/{id}', [Authadmin::class, 'usersEdit']);
    Route::post('createRestaurant', [Authadmin::class, 'createRestaurant']);


});
Route::middleware(['auth:sanctum', 'abilities:user'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //CART CONTROLLER
    Route::post('/cartGoing/{id}', [CartController::class, 'cartGoing']);//react
    Route::post('/cartDone/{id}', [CartController::class, 'cartDone']);//react
    Route::get('/cartView', [CartController::class, 'index']);//react
    Route::get('/cartGoingView', [CartController::class, 'cartGoingView']);//react
    Route::get('/cartDoneView', [CartController::class, 'cartDoneView']);//react
    Route::get('/dailyReport', [CartController::class, 'dailyReport']);//react
    Route::get('/monthlyReport', [CartController::class, 'monthlyReport']);//react
    //PRODUCT CONTROLLER
    Route::get('/productView', [ProductController::class, 'index']);//react
    Route::post('/productStore', [ProductController::class, 'store']);//react
    Route::post('/productEdit/{id}', [ProductController::class, 'update']);//react
    Route::delete('/productDelete/{id}', [ProductController::class, 'destroy']);//react
    Route::get('/giftView', [ProductController::class, 'giftView']);//react
    Route::post('/giftStore', [ProductController::class, 'giftStore']);//react
    Route::post('/giftActive/{id}', [ProductController::class, 'giftActive']);//react
    Route::post('/giftEdit/{id}', [ProductController::class, 'giftupdate']);//react
    Route::delete('/giftDelete/{id}', [ProductController::class, 'giftdestroy']);//react
    //TYPE CONTROLLER
    Route::get('/typeView', [TypeController::class, 'index']);//react
    Route::post('/typeStore', [TypeController::class, 'store']);//react
    Route::post('/typeEdit/{id}', [TypeController::class, 'update']);//react
    Route::delete('/typeDelete/{id}', [TypeController::class, 'destroy']);//react
    //RATE CONTROLLER
    Route::get('/rateView', [RateController::class, 'index']);//react
    Route::get('/rateCustomView/{id}', [RateController::class, 'show']);//react
    //FEEDBACK CONTROLLER
    Route::get('/feedbackView', [FeedbackController::class, 'index']);//react
    Route::get('/feedbackReadView', [FeedbackController::class, 'index2']);//react
    Route::post('/feedbackRead/{id}', [FeedbackController::class, 'feedbackRead']);//react
    //MENU CONTROLLER
    Route::get('/outOfMenu', [MenuController::class, 'outOfMenu']);//react
    Route::post('/menuStore', [MenuController::class, 'store']);//react
    Route::delete('/menuDelete/{id}', [MenuController::class, 'destroy']);//react
    Route::get('/Menu', [MenuController::class, 'index']);//react
    //CUSTOMER CONTROLLER
    Route::get('/customerView', [CustomerController::class, 'index']);//react
});

///////////////////////////////flutter api////////////////////////////////
//CUSTOMER CONTROLLER
Route::post('/customerStore', [CustomerController::class, 'Store']);//flutter
//ORDER CONTROLLER
Route::post('/orderStore', [OrderController::class, 'Store']);//flutter
Route::post('/testList', [OrderController::class, 'testList']);//flutter
Route::get('/teeest', [OrderController::class, 'teeest']);//flutterteeest
Route::get('/t', [OrderController::class, 't']);//flutterteeest
Route::post('/del', [OrderController::class, 'del']);//flutterteeest



//CART CONTROLLER
Route::get('/orderCustomerView/{customer_id}', [CartController::class, 'index2']);//flutter
Route::get('/random5/{customer_id}', [CartController::class, 'random5']);//flutter
//FEEDBACK CONTROLLER
Route::post('/feedbackStore', [FeedbackController::class, 'store']);//flutter
//RATE CONTROLLER
Route::get('/rateView/{id}', [RateController::class, 'show']);//flutter
Route::post('/rateStore', [RateController::class, 'store']);//flutter
//ADMIN CONTROLLER
Route::get('restaurantView', [Authadmin::class, 'restaurantView']);//flutter



