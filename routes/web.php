<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Order::latest();
    
    // Filtro por Estatus
    if ($request->filled('status') && $request->status !== 'Estado: Todos' && $request->status !== 'Todos') {
        $query->where('status', $request->status);
    }
    
    // Buscador General (case insensitive in most databases, but let's be sure it searches all fields)
    if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function($q) use ($search) {
            $q->where('client_name', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('order_number', 'like', "%{$search}%")
              ->orWhere('material', 'like', "%{$search}%");
        });
    }

    $orders = $query->get();
    
    // Para los contadores globales independientemente del filtro actual
    $allOrdersCount = \App\Models\Order::count();
    $cotizadosCount = \App\Models\Order::where('status', 'Cotizado')->count();
    $enProduccionCount = \App\Models\Order::where('status', 'En producción')->count();
    $entregadosCount = \App\Models\Order::where('status', 'Entregado')->count();

    return view('dashboard', compact('orders', 'allOrdersCount', 'cotizadosCount', 'enProduccionCount', 'entregadosCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin/Ops Orders
    Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    
    // Vistas Beta (Prototipos para presentación)
    Route::view('/inicio', 'home')->name('home');
    Route::view('/clientes', 'clients')->name('clients.index');
    Route::view('/empresas', 'companies')->name('companies.index');
    Route::view('/materiales', 'materials')->name('materials.index');
    Route::view('/reportes', 'reports')->name('reports.index');
    Route::view('/ajustes', 'settings')->name('settings.index');
    Route::view('/ayuda', 'help')->name('help.index');
});

// Public route for clients
Route::get('/pedido-cliente', [\App\Http\Controllers\OrderController::class, 'create'])->name('client.order.create');
Route::post('/pedido-cliente', [\App\Http\Controllers\OrderController::class, 'store'])->name('client.order.store');

require __DIR__.'/auth.php';

// Shopify Webhooks
Route::post('/webhook/shopify/orders/create', [\App\Http\Controllers\ShopifyWebhookController::class, 'handleOrderCreate'])->name('webhook.shopify.orders.create');
