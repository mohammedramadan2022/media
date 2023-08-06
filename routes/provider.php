<?php

use App\Http\Controllers\Provider\Auth\ProviderLoginController;
use App\Http\Controllers\Provider\{HomeController, OrderController, ProductController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Auth')->as('provider.')->group(function () {
    Route::get('/login', [ProviderLoginController::class, 'showProviderLoginForm'])->name('login');
    Route::post('/login', [ProviderLoginController::class, 'providerLogin'])->name('submit.login');

    Route::get('/forget-password', [ProviderLoginController::class, 'forgetPassword'])->name('forget-password');
    Route::post('/forget-password-submit', [ProviderLoginController::class, 'sendResetMail'])->name('forget-password-submit');

    Route::get('/confirmed-reset-mail', [ProviderLoginController::class, 'confirmedResetMail'])->name('confirmedResetMail');
    Route::get('/provider-reset-password/{token}', [ProviderLoginController::class, 'providerResetPassword'])->name('reset-password');
    Route::post('/provider-change-password', [ProviderLoginController::class, 'providerChangePassword'])->name('changePassword');
    Route::post('/logout', [ProviderLoginController::class, 'providerLogout'])->name('logout');
});

Route::group(['middleware' => ['auth:provider']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('provider-panel');

    Route::as('provider.')->group(function () {
        // Not Found
        Route::view('/not-found','Provider.layouts.notFound')->name('not-found');

        // Profile
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::post('/profile', [HomeController::class, 'profileUpdate'])->name('profile-update');

        // Products
        Route::resource('products', ProductController::class)->except('show');
        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/rental-products', [ProductController::class, 'rentalProducts'])->name('rental-products');
            Route::get('/{product}/show', [ProductController::class, 'show'])->name('show');
            Route::post('/ajax-get-categories-by-section-id', [ProductController::class, 'getCategoriesBySectionId'])->name('getCategoriesBySectionId');
            Route::post('/ajax-remove-image-from-list', [ProductController::class, 'removeImageFromList'])->name('ajax-remove-image-from-list');
            Route::post('/ajax-delete-product', [ProductController::class, 'delete'])->name('ajax-delete-product');
            Route::get('/products-search', [ProductController::class, 'search'])->name('search');
        });

        // Orders
        Route::resource('orders', OrderController::class)->except('show');
        Route::get('/orders/{order}/show', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/ajax-delete-order', [OrderController::class, 'delete'])->name('orders.ajax-delete-order');
        Route::get('/orders-search', [OrderController::class, 'search'])->name('orders.search');
        Route::get('/orders-accept/{order}/action', [OrderController::class, 'accept'])->name('orders.accept');
        Route::get('/orders-reject/{order}/action', [OrderController::class, 'reject'])->name('orders.reject');
    });
});
