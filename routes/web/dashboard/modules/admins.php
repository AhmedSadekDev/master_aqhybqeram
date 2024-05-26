<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admins\AdminsController;

Route::get('/admins/{admin}/change-active', [AdminsController::class,'changeActive'])->name('admins.change.active')->where('admin','[0-9]+');
Route::resource('/admins', AdminsController::class);