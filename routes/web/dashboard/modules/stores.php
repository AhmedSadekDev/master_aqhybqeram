<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Stores\StoresController;

Route::get('/stores/{store}/rates', [StoresController::class,"rateIndex"])->name('stores.rates.index')->where('store','[0-9]+');
Route::delete('/stores/{store}/rates/{rate}', [StoresController::class,"rateDestroy"])->name('stores.rates.destroy')->where('store','[0-9]+')->where('rate','[0-9]+');
Route::get('/stores/{store}/offer', [StoresController::class,"changeOffer"])->name('stores.offer')->where('store','[0-9]+');
Route::get('/stores/{store}/more_choice', [StoresController::class,"changeMoreChoice"])->name('stores.more_choice')->where('store','[0-9]+');
Route::get('/stores/{store}/recommend', [StoresController::class,"changeRecommend"])->name('stores.recommend')->where('store','[0-9]+');
Route::get('/stores/{store}/unmissable_offer', [StoresController::class,"changeUnmissableOffer"])->name('stores.unmissable_offer')->where('store','[0-9]+');
Route::resource('/stores', StoresController::class);