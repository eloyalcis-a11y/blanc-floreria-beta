<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDelivered;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'client_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            'product_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'sender_name' => 'nullable|string|max:255',
            'shipping_cost' => 'nullable|numeric|min:0',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable|string|max:255',
            'delivery_address' => 'nullable|string',
            'client_phone' => 'nullable|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'dedication_message' => 'nullable|string',
            'salesperson' => 'nullable|string|max:255',
            'reference_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];

        // Solo exigimos comprobante si es cliente. Si es admin, puede que lo pague después o en efectivo.
        if (!auth()->check() || auth()->user()->role === 'cliente') {
            $rules['payment_proof'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        } else {
            $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
        }

        $validated = $request->validate($rules);

        $validated['order_number'] = 'PD-' . rand(1000, 9999);
        $validated['user_id'] = auth()->id() ?? 1; // Fallback to 1 if not logged in
        
        if (!auth()->check() || auth()->user()->role === 'cliente') {
            $validated['status'] = 'Pendiente de Pago';
        } else {
            $validated['status'] = 'Cotizado';
        }
        
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof_path'] = $path;
        }

        if ($request->hasFile('reference_image')) {
            $path = $request->file('reference_image')->store('reference_images', 'public');
            $validated['reference_image_path'] = $path;
        }
        
        $order = \App\Models\Order::create($validated);

        // Notificar a administradores, ventas y operaciones
        $staff = User::whereIn('role', ['admin', 'ventas', 'operacion'])->get();
        if ($staff->count() > 0) {
            Notification::send($staff, new NewOrderNotification($order));
        }

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

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Pendiente de Pago,Cotizado,Confirmado,En proceso,En ruta,Entregado',
            'delivery_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $updates = ['status' => $validated['status']];

        if ($validated['status'] === 'Entregado' && $request->hasFile('delivery_photo')) {
            $path = $request->file('delivery_photo')->store('delivery_photos', 'public');
            $updates['delivery_photo_path'] = $path;
        }

        $order->update($updates);

        if ($validated['status'] === 'Entregado' && $order->client_email) {
            Mail::to($order->client_email)->send(new OrderDelivered($order));
        }
        
        return redirect()->back()->with('success', 'Estatus actualizado.');
    }

    public function updateFinancials(Request $request, \App\Models\Order $order)
    {
        $validated = $request->validate([
            'unit_price' => 'nullable|numeric|min:0',
            'extra_charge' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'ticket_number' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        // Actualizar total dinámicamente si es necesario, o lo calculamos al vuelo en reportes
        $total = ($order->unit_price ?? 0) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0) - ($order->discount ?? 0);
        $order->update(['total_price' => $total]);

        return redirect()->back()->with('success', 'Datos financieros actualizados.');
    }
}
