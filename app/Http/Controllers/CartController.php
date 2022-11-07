<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class CartController extends Controller
{

    public function create(Request $request) {
        $cart = new Cart([
            'product_id' => $request->input('product_id'),
            'user_id' => $request->input('user_id'), 
            'quantity' => $request->input('quantity') ?? 1,
            'checkout_price' => $request->input('price')
        ]);
        if ($cart->save()) {
            return response('Success', 200);
        }
        return response('Error: Could not add to cart', 500);
    }

    public function show(Request $request) {
        $user = User::findorfail($request->input('user'));
        return response()
            ->json(['items' => $user->cart, 'cartTotal' => $user->cartTotal()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        if($cart->delete()) {
            return response('Success', 200);
        };

        return response('Error', 500);
    }

    public function clear(Request $request) {
        $user = $request->user();
        $user->cart()->detach();
    }
}
