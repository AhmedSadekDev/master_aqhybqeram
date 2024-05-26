<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Customers\CustomersController;

Route::get('/customers/{customer}/history', [CustomersController::class,'history'])->name('customers.history')->where('customer','[0-9]+');
Route::resource('/customers', CustomersController::class);