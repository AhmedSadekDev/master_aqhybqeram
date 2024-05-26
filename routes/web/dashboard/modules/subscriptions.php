<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Subscriptions\SubscriptionsController;

Route::resource('/subscriptions', SubscriptionsController::class);