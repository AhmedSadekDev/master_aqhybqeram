<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// Profile
Route::get('/profile', [ProfileController::class,'index'])->name('profile.index');
Route::post('/profile', [ProfileController::class,'store'])->name('profile.store');
// Logout
Route::get('/logout', [HomeController::class,'logout'])->name('logout');

