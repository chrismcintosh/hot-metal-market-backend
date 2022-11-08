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
    $order = \App\Models\Order::firstWhere('stripe_payment_intent_id', 'pi_3M1bvbDsQ6PpbGwC0DBbA0Zu');
    $order->status = "succeeded";
    $order->save();
});


Route::stripeWebhooks('/stripe-webhooks');

/**
 * Protected Routes
 */
Route::middleware(['auth:sanctum'])->group(function() {
    // Products
    Route::resource('products', App\Http\Controllers\ProductController::class);
    
    // Carts
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'show']);
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'create']);
    Route::delete('/carts/{cart}', [App\Http\Controllers\CartController::class, 'destroy']);
});


/**
 * Unprotected Routes
 */

// Products
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);

// Stripe
Route::post('/stripe/generatePaymentIntent', [App\Http\Controllers\StripeController::class, 'generatePaymentIntent']);

// User
Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cart/clear', [App\Http\Controllers\CartController::class, 'clear']);