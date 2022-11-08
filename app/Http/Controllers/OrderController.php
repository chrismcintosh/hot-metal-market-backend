<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request) {
        \Log::debug('order index request');
        \Log::debug(json_encode($request));
        if($request->has('user_id')) {
            return Order::where('user_id', $request->input('user_id'))->get()->toJson();
        }
        
        return Order::all()->toJson();
    }
}
