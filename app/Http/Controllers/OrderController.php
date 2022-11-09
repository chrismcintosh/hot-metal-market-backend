<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request) {
        if($request->has('user')) {
            return Order::where('user_id', $request->input('user'))
                ->where('status', '!=', 'pi_generated')
                ->get()
                ->toJson();
        }
        return Order::where('status', '!=', 'pi_generated')
            ->toJson();
    }

    public function show(Order $order) {
        $order->load('products');
        return $order;
    }
}
