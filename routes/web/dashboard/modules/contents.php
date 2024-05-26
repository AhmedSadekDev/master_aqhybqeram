<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Contents\ContentsController;

Route::resource('/contents', ContentsController::class);