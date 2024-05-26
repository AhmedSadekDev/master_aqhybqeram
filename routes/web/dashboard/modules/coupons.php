<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Coupons\CouponsController;

Route::resource('/coupons', CouponsController::class);