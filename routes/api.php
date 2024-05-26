<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\Notifications\NotificationsController;
use App\Http\Controllers\API\Settings\SettingsController;
// ========================== //
use App\Http\Controllers\API\ContactUs\ContactUsController;
use App\Http\Controllers\API\Home\HomeController;
// ========================== //
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Stores\StoresController;
use App\Http\Controllers\API\Subscriptions\SubscriptionsController;
// ========================== //
use App\Http\Controllers\API\Fav\FavController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// LOGIN
Route::post('/login',[AuthController::class, 'login']);
// Check Phone
Route::post('/check-phone',[AuthController::class, 'checkPhone']);
// Verified Phone
// Route::post('/verified-phone',[AuthController::class, 'verifiedPhone'])->middleware('auth:api');
// REGISTER NEW ACCOUNT
Route::post('/register',[AuthController::class, 'register']);
// FORGET PASSWORD
Route::post('/forget-password',[AuthController::class, 'forgetPassword']);
// RESET PASSWORD
Route::post('/reset-password',[AuthController::class, 'resetPassword']);


// SETTINGS
Route::get('/settings',[SettingsController::class, 'index']);

// HOME
Route::get('/home',[HomeController::class, 'index']);
// CONTACT US
Route::post('/contact-us',[ContactUsController::class, 'store']);

Route::get('/check-my-subscription',[ProfileController::class, 'checkMySubscription'])->middleware('auth:api');

// PROFILE
Route::get('/profile',[ProfileController::class, 'index'])->middleware('auth:api');
Route::post('/profile',[ProfileController::class, 'update'])->middleware('auth:api');
Route::get('/profile/notification',[NotificationsController::class, 'index'])->middleware('auth:api');
Route::delete('/profile/notification/{notification}',[NotificationsController::class, 'destroy'])->where('notification','[0-9]+')->middleware('auth:api');

// Delete Account
Route::get('/profile/delete-account',[ProfileController::class, 'destroy'])->middleware('auth:api');

// Change Password
Route::post('/change-password',[ProfileController::class, 'changePassword'])->middleware('auth:api');
// Change Email
Route::post('/change-email',[ProfileController::class, 'changeEmail'])->middleware('auth:api');
// Change Phone
Route::post('/change-phone',[ProfileController::class, 'changePhone'])->middleware('auth:api');
// logout
Route::get('/logout',[ProfileController::class, 'logout'])->middleware('auth:api');

// FAV
Route::get('/store-favorite',[FavController::class, 'index'])->middleware('auth:api');
Route::post('/store-favorite/{store}',[FavController::class, 'store'])->where('store','[0-9]+')->middleware('auth:api');
Route::delete('/store-favorite/{store}',[FavController::class, 'destroy'])->where('store','[0-9]+')->middleware('auth:api');

// Categories
Route::get('/categories',[CategoryController::class, 'index']);
Route::get('/categories/{category}',[CategoryController::class, 'show'])->where('category','[0-9]+');

// Subscriptions
Route::get('/subscriptions',[SubscriptionsController::class, 'index']);
Route::post('/subscriptions',[SubscriptionsController::class, 'store'])->middleware('auth:api');
// SEARCH
Route::post('/search',[HomeController::class, 'search']);

Route::get('/stores',[StoresController::class, 'index']);
Route::get('/stores/{store}',[StoresController::class, 'show'])->middleware('user.subscription')->where('store','[0-9]+')->middleware('auth:api');
Route::get('/stores/{store}/rates',[StoresController::class, 'getStoreRates'])->where('store','[0-9]+');
Route::post('/stores/{store}/rate',[StoresController::class, 'rateStore'])->where('store','[0-9]+')->middleware('auth:api');
Route::get('/stores/{store}/coupons',[StoresController::class, 'coupons'])->middleware('user.subscription')->where('store','[0-9]+')->middleware('auth:api');
Route::get('/stores/{store}/coupons/{coupon}',[StoresController::class, 'showCoupon'])->middleware('user.subscription')->middleware('auth:api')->where('store','[0-9]+')->where('coupon','[0-9]+');


Route::get('/stores/offer',[StoresController::class, 'storeOffer']);
Route::get('/stores/more_choice',[StoresController::class, 'storeMoreChoice']);
Route::get('/stores/recommend',[StoresController::class, 'storeRecommend']);
Route::get('/stores/unmissable_offer',[StoresController::class, 'storeUnmissableOffer']);