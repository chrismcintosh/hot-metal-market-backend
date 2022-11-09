<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request) {
        if($request->has('user')) {
            return Order::where('user_id', $request->input('user'))->get()->toJson();
        }
        return Order::all()->toJson();
    }

    public function show(Order $order) {
        $order->load('products');
        return $order;
    }
}
