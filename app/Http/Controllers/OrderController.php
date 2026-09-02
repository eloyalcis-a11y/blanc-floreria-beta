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
            'arrangement_type' => 'required|in:catalogo,personalizado',
            'client_name' => 'required|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            'payroll_rfc' => 'nullable|string|max:255',
            'payroll_area' => 'nullable|string|max:255',
            'accounts_receivable_entity' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'sender_name' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'shipping_cost' => 'nullable|numeric|min:0',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable|string|max:255',
            'delivery_street' => 'nullable|string|max:255',
            'delivery_neighborhood' => 'nullable|string|max:255',
            'delivery_zip' => 'nullable|string|max:20',
            'delivery_references' => 'nullable|string',
            'client_phone' => 'nullable|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'dedication_message' => 'nullable|string',
            'salesperson' => 'nullable|string|max:255',
            'reference_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'delivery_reference_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'shopify_image_url' => 'nullable|url',
        ];

        // El comprobante no es obligatorio para ventas/staff, pueden agregarlo después
        $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

        $validated = $request->validate($rules);

        // Generar folio secuencial (PD-0001, PD-0002...)
        $lastOrder = \App\Models\Order::where('order_number', 'like', 'PD-%')->orderBy('id', 'desc')->first();
        if ($lastOrder) {
            $lastNumber = intval(str_replace('PD-', '', $lastOrder->order_number));
            $validated['order_number'] = 'PD-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $validated['order_number'] = 'PD-0001';
        }
        $validated['user_id'] = auth()->id();
        
        $validated['status'] = 'En proceso';

        // Evitar error 500 por emojis (si la base de datos no es utf8mb4)
        if (isset($validated['dedication_message'])) {
            $validated['dedication_message'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $validated['dedication_message']);
        }
        if (isset($validated['notes'])) {
            $validated['notes'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $validated['notes']);
        }
        
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof_path'] = $path;
        }

        if ($request->hasFile('reference_image')) {
            $path = $request->file('reference_image')->store('reference_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif ($request->filled('shopify_image_url')) {
            $validated['image_url'] = $request->input('shopify_image_url');
        }

        if ($request->hasFile('delivery_reference_image')) {
            $path = $request->file('delivery_reference_image')->store('delivery_references', 'public');
            $validated['delivery_reference_image_path'] = '/storage/' . $path;
        }
        
        try {
            $order = \App\Models\Order::create($validated);
        } catch (\Exception $e) {
            \Log::error('Error creando pedido manual: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ocurrió un error al guardar el pedido en la base de datos. Si usaste caracteres especiales, intenta quitarlos.');
        }

        // Notificar a administradores, ventas y operaciones (App)
        $staff = User::whereIn('role', ['admin', 'ventas', 'operacion'])->get();
        if ($staff->count() > 0) {
            try {
                Notification::send($staff, new NewOrderNotification($order));
            } catch (\Exception $e) {
                \Log::error('Error enviando notificación push/email: ' . $e->getMessage());
            }
        }

        // Enviar correo a la lista de distribución
        try {
            Mail::to([
                'jaky.vazquez@alciscorp.com',
                'andrea.orquidea@alciscorp.com',
                'atencionaclientes@blancfloreria.com.mx',
                'asistente2@alciscorp.com'
            ])->send(new \App\Mail\OrderCreatedMail($order));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de nuevo pedido manual: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'Pedido creado exitosamente.');
    }

    public function show(\App\Models\Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function print(\App\Models\Order $order)
    {
        return view('orders.print', compact('order'));
    }

    public function edit(\App\Models\Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        $rules = [
            'arrangement_type' => 'required|in:catalogo,personalizado',
            'client_name' => 'required|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            'payroll_rfc' => 'nullable|string|max:255',
            'payroll_area' => 'nullable|string|max:255',
            'accounts_receivable_entity' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'sender_name' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'shipping_cost' => 'nullable|numeric|min:0',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable|string|max:255',
            'delivery_street' => 'nullable|string|max:255',
            'delivery_neighborhood' => 'nullable|string|max:255',
            'delivery_zip' => 'nullable|string|max:20',
            'delivery_references' => 'nullable|string',
            'client_phone' => 'nullable|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'dedication_message' => 'nullable|string',
            'salesperson' => 'nullable|string|max:255',
            'salesperson' => 'nullable|string|max:255',
            'reference_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'delivery_reference_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'shopify_image_url' => 'nullable|url',
        ];

        $validated = $request->validate($rules);

        // Evitar error 500 por emojis (si la base de datos no es utf8mb4)
        if (isset($validated['dedication_message'])) {
            $validated['dedication_message'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $validated['dedication_message']);
        }
        if (isset($validated['notes'])) {
            $validated['notes'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $validated['notes']);
        }

        if ($request->hasFile('reference_image')) {
            $path = $request->file('reference_image')->store('reference_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif ($request->filled('shopify_image_url')) {
            $validated['image_url'] = $request->input('shopify_image_url');
        }

        if ($request->hasFile('delivery_reference_image')) {
            $path = $request->file('delivery_reference_image')->store('delivery_references', 'public');
            $validated['delivery_reference_image_path'] = '/storage/' . $path;
        }

        try {
            $order->update($validated);
        } catch (\Exception $e) {
            \Log::error('Error actualizando pedido manual: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ocurrió un error al actualizar el pedido en la base de datos. Si usaste caracteres especiales, intenta quitarlos.');
        }

        return redirect()->route('dashboard')->with('success', 'Pedido actualizado exitosamente.');
    }

    public function toggleRoute(Request $request, \App\Models\Order $order)
    {
        $order->update([
            'is_in_route' => !$order->is_in_route,
            'driver_name' => $request->driver_name ?? $order->driver_name
        ]);
        
        return redirect()->back()->with('success', 'Estado de ruta actualizado.');
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:En proceso,En ruta,Entregado,Cerrado (Pagado)',
            'delivery_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $updates = ['status' => $validated['status']];

        if ($validated['status'] === 'Entregado y Pagado' && $request->hasFile('delivery_photo')) {
            $path = $request->file('delivery_photo')->store('delivery_photos', 'public');
            $updates['delivery_photo_path'] = $path;
        }

        $order->update($updates);

        if ($validated['status'] === 'Entregado y Pagado' && $order->client_email) {
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
        $total = (($order->unit_price ?? 0) * (1 - ($order->discount ?? 0) / 100)) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0);
        $order->update(['total_price' => $total]);

        return redirect()->back()->with('success', 'Datos financieros actualizados.');
    }
}
