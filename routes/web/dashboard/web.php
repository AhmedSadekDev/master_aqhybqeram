<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::prefix('dashboard')->group(function () {
    // Auth::routes();
    // checkAuth
    Route::get('/login', [\App\Http\Controllers\Dashboard\Auth\AuthController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Dashboard\Auth\AuthController::class, 'checkAuth'])->name('dashboard.checkAuth');
    Route::name('dashboard.')->middleware(['auth.dashboard'])->group(function () {
        include __DIR__.'/modules/global.php';
        include __DIR__.'/modules/settings.php';
        // =======================================//
        include __DIR__.'/modules/admins.php';
        include __DIR__.'/modules/customers.php';
        include __DIR__.'/modules/stores.php';
        // =======================================//
        // =======================================//
        // =======================================//
        include __DIR__.'/modules/sliders.php';
        include __DIR__.'/modules/intros.php';
        include __DIR__.'/modules/contact-us.php';
        include __DIR__.'/modules/categories.php';
        include __DIR__.'/modules/coupons.php';
        include __DIR__.'/modules/contents.php';
        include __DIR__.'/modules/subscriptions.php';
        // =======================================//
        include __DIR__.'/modules/notification.php';
    });
});
