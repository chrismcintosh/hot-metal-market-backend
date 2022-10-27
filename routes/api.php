<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

Route::get('/testing', function() {
    $item = App\Models\User::find(1);
    return $item->cartTotal();
});


/**
 * Auth Routes
 */
Route::middleware(['auth:sanctum'])->group(function() {
    Route::resource('products', App\Http\Controllers\ProductController::class);
    
    // Carts
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'show']);
    Route::delete('/carts/{cart}', [App\Http\Controllers\CartController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


/**
 * Unprotected Routes
 */
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
