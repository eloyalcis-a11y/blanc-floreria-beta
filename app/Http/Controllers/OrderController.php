<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $validated['order_number'] = 'PD-' . rand(1000, 9999);
        $validated['user_id'] = auth()->id() ?? 1; // Fallback to 1 if not logged in (e.g. public form)
        $validated['status'] = 'Cotizado';
        
        \App\Models\Order::create($validated);

        return redirect()->route('dashboard')->with('success', 'Pedido creado exitosamente.');
    }

    public function show(\App\Models\Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function toggleRoute(\App\Models\Order $order)
    {
        $order->update([
            'is_in_route' => !$order->is_in_route
        ]);
        
        return redirect()->back()->with('success', 'Estado de ruta actualizado.');
    }
}
