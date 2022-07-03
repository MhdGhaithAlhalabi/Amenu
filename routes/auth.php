<?php
use App\Http\Controllers\Authuser;
use App\Http\Controllers\Authadmin;
use Illuminate\Support\Facades\Route;
//////admin/////
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::post('register', [Authuser::class, 'registeruser']);
});
//////api////////
Route::post('adminregister', [Authadmin::class, 'registeradmin'])
    ->name('register.admin.store');

Route::post('/login', [Authuser::class, 'login'])
    ->middleware('guest')
    ->name('login');
////////admin-user//////
Route::post('/logout', [Authuser::class, 'destroy'])
    ->middleware(['auth:sanctum','ability:admin,user'])
    ->name('logout');




//use App\Http\Controllers\Auth\AuthenticatedSessionController;
//use App\Http\Controllers\Auth\EmailVerificationNotificationController;
//use App\Http\Controllers\Auth\NewPasswordController;
//use App\Http\Controllers\Auth\PasswordResetLinkController;
//use App\Http\Controllers\Auth\RegisteredUserController;
//use App\Http\Controllers\Auth\VerifyEmailController;
//use App\Http\Controllers\RegisteredAdminController;

//Route::middleware('auth:apiAdmin')->group(function () {
////    Route::get('register', [RegisteredUserController::class, 'create'])
////        ->name('register');
//    Route::post('register', [RegisteredUserController::class, 'store']);
//});
////Route::post('/register', [RegisteredUserController::class, 'store'])
////                ->middleware('guest')
////                ->name('register');
//Route::post('adminregister', [RegisteredAdminController::class, 'store'])
//    ->name('register.admin.store');
//
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//                ->middleware('guest')
//                ->name('login');
//
////Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
////                ->middleware('guest')
////                ->name('password.email');
//
////Route::post('/reset-password', [NewPasswordController::class, 'store'])
////                ->middleware('guest')
////                ->name('password.update');
////////////////////////////////
////Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
////                ->middleware(['auth:user,admin', 'signed', 'throttle:6,1'])
////                ->name('verification.verify');
//
////Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
////                ->middleware(['auth:user,admin', 'throttle:6,1'])
////                ->name('verification.send');
//
//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->middleware('auth:apiUser,apiAdmin')
//                ->name('logout');
