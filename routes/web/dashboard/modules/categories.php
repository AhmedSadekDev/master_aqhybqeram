<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Categories\CategoriesController;

Route::get('/categories/{category}/changeStatus', [CategoriesController::class,"changeStatus"])->name('categories.change-status')->where('slider','[0-9]+');
Route::resource('/categories', CategoriesController::class);