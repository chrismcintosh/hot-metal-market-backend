<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class CartController extends Controller
{
    public function show(Request $request) {
        // Replace hard code with request value
        \Log::debug($request->all());
        $user = User::findorfail(1);
        return json_encode($user->cart);
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
}
