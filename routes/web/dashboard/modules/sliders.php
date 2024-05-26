<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Sliders\SlidersController;

Route::get('/sliders/{slider}/changeStatus', [SlidersController::class,"changeStatus"])->name('sliders.change-status')->where('slider','[0-9]+');
Route::resource('/sliders', SlidersController::class);