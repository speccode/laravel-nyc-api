<?php

use Illuminate\Support\Facades\Route;
use Speccode\BestSellers\Infrastructure\Http\Controllers\GetBestSellersList;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/1/nyt/best-sellers', GetBestSellersList::class)->name('best-sellers');
