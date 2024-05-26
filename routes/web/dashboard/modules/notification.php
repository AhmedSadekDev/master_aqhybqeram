<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Notification\NotificationController;

Route::resource('/notifications', NotificationController::class);