<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function generatePaymentIntent(Request $request) {

        $amount = $request->input('amount');

        $cart = $request->input('cart');
        $cart = collect($cart['items'])->map(function($item) {
            \Log::debug($item);
            return [
                'product_id' => $item['pivot']['product_id'], 
                'quantity' => $item['pivot']['quantity'],
                'price' => $item['pivot']['checkout_price']
            ];
        });

        $key = env('STRIPE_SECRET_KEY');
        $stripe = new \Stripe\StripeClient($key);
        
        return json_encode($stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'metadata' => [
                'user' => $request->input('user'),
                'cart' => $cart
            ]
        ]));
    }
}
