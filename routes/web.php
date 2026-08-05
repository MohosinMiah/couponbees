<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/* ── Frontend ── */
Route::get('/', [StoreController::class, 'home'])->name('home');
Route::get('/prop-firms', [StoreController::class, 'propfirms'])->name('stores.propfirms');
Route::get('/brokers', [StoreController::class, 'brokers'])->name('stores.brokers');
Route::get('/stores/load-more', [StoreController::class, 'loadMore'])->name('stores.load-more');
Route::get('/search/stores', [StoreController::class, 'search'])->name('stores.search');
Route::get('/become-a-sponsor', [SponsorController::class, 'show'])->name('become-a-sponsor');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::get('/store/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
Route::post('/coupon/{coupon}/copy', [CouponController::class, 'copy'])->name('coupons.copy');
Route::post('/coupon/{coupon}/feedback', [CouponController::class, 'feedback'])->name('coupons.feedback');

/* ── Admin Auth ── */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login',  [Admin\AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('logout',[Admin\AuthController::class, 'logout'])->name('logout');

    /* ── Protected Admin Routes ── */
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Store CRUD
        Route::resource('stores', Admin\StoreController::class);

        // Category CRUD
        Route::resource('categories', Admin\CategoryController::class)->except(['show']);

        // Sponsor CRUD
        Route::resource('sponsors', Admin\SponsorController::class)->except(['show']);

        // Coupon CRUD
        Route::resource('coupons', Admin\CouponController::class);
        Route::post('coupons/{coupon}/reset-stats', [Admin\CouponController::class, 'resetStats'])->name('coupons.reset-stats');

        // Settings
        Route::get('settings/homepage', [Admin\SettingController::class, 'homepage'])->name('settings.homepage');
        Route::post('settings/homepage', [Admin\SettingController::class, 'updateHomepage'])->name('settings.homepage.update');
    });
});
