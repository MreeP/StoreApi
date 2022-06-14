<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth-token.parser'])->name('api.')->group(function () {
    Route::middleware(['api.authentication'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::prefix('products')->name('products.')->group(function () {
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::patch('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('prices')->name('prices.')->group(function () {
            Route::get('/{price}', [PriceController::class, 'show'])->name('show');
            Route::post('/', [PriceController::class, 'store'])->name('store');
            Route::patch('/{price}', [PriceController::class, 'update'])->name('update');
            Route::delete('/{price}', [PriceController::class, 'destroy'])->name('destroy');
        });
    });

    Route::post('login', [AuthController::class, 'login']);

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('/{product:id}', [ProductController::class, 'show'])->name('show');
    });
});
