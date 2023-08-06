<?php

use App\Http\Controllers\VueController;
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

Route::get('/orders/{order_id}/invoice', [VueController::class, 'pdfview'])->name('admin.pdfview');

Route::get('/{any?}', VueController::class)
    ->where('any', '[\/\w\.-]*')
    ->middleware('check.debug.mode')
    ->name('front.home');
