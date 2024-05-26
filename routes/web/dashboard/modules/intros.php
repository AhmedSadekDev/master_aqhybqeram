<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Intros\IntrosController;

Route::resource('/intros', IntrosController::class);