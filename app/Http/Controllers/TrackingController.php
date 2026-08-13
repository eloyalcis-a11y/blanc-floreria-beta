<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class TrackingController extends Controller
{
    public function show($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('tracking.show', compact('order'));
    }
}
