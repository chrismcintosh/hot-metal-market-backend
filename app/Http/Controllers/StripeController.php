<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class StripeController extends Controller
{
    public function generatePaymentIntent(Request $request) {

        $amount = $request->input('amount');

        $cart = $request->input('cart');
        $cart = collect($cart['items'])->map(function($item) {
            return [
                'product_id' => $item['pivot']['product_id'], 
                'quantity' => $item['pivot']['quantity'],
                'price' => $item['pivot']['checkout_price']
            ];
        });

        $key = env('STRIPE_SECRET_KEY');
        $stripe = new \Stripe\StripeClient($key);

        $order = new Order([
            'status' => 'pi_generated',
            'user_id' => $request->user()->id,
            'total' => $amount
        ]);

        $order->save();

        $pi = $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'metadata' => [
                'user' => $request->input('user'),
                'cart' => $cart,
                'order_id'=> $order->id
            ]
        ]);

        $order->stripe_payment_intent_id = $pi->id;
        $order->save();
        
        return json_encode($pi);
    }
}
