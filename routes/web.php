<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Order::latest();
    
    // Candado de seguridad: Si es cliente, solo ve sus pedidos
    if (auth()->user()->role === 'cliente') {
        $query->where('user_id', auth()->id());
    }
    
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

    // Filtros Rápidos Logísticos
    if ($request->filled('filter')) {
        if ($request->filter === 'proximas') {
            $query->whereNotNull('delivery_date')
                  ->where('status', '!=', 'Entregado')
                  ->orderBy('delivery_date', 'asc');
        } elseif ($request->filter === 'en_ruta') {
            $query->where('is_in_route', true)
                  ->where('status', '!=', 'Entregado');
        } elseif ($request->filter === 'por_vencer') {
            $query->whereNotNull('delivery_date')
                  ->where('status', '!=', 'Entregado')
                  ->where('delivery_date', '<=', now()->addDays(2))
                  ->orderBy('delivery_date', 'asc');
        }
    }

    $orders = $query->paginate(10)->withQueryString();
    
    // Para los contadores globales
    $baseQuery = \App\Models\Order::query();
    if (auth()->user()->role === 'cliente') {
        $baseQuery->where('user_id', auth()->id());
    }

    $allOrdersCount = (clone $baseQuery)->count();
    $cotizadosCount = (clone $baseQuery)->where('status', 'Cotizado')->count();
    $enProduccionCount = (clone $baseQuery)->where('status', 'En producción')->count();
    $entregadosCount = (clone $baseQuery)->where('status', 'Entregado')->count();

    return view('dashboard', compact('orders', 'allOrdersCount', 'cotizadosCount', 'enProduccionCount', 'entregadosCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin/Ops Orders
    Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/toggle-route', [\App\Http\Controllers\OrderController::class, 'toggleRoute'])->name('orders.toggle-route');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Vistas Beta (Prototipos para presentación)
    Route::view('/inicio', 'home')->name('home');
    Route::view('/clientes', 'clients')->name('clients.index');
    Route::view('/empresas', 'companies')->name('companies.index');
    Route::view('/materiales', 'materials')->name('materials.index');
    Route::get('/reportes', function() {
        $totalVentas = \App\Models\Order::where('status', 'Entregado')->sum('total_price');
        $pedidosPorMes = \App\Models\Order::selectRaw('strftime("%m", created_at) as mes, count(*) as total')
            ->groupBy('mes')
            ->get();
        $pedidosActivos = \App\Models\Order::where('status', '!=', 'Entregado')->count();
        $topClientes = \App\Models\Order::selectRaw('client_name, count(*) as pedidos, sum(total_price) as gastado')
            ->groupBy('client_name')
            ->orderByDesc('gastado')
            ->limit(5)
            ->get();
            
        return view('reports', compact('totalVentas', 'pedidosPorMes', 'pedidosActivos', 'topClientes'));
    })->name('reports.index');
    Route::view('/ajustes', 'settings')->name('settings.index');
    Route::view('/ayuda', 'help')->name('help.index');
});

// Public route for clients
Route::get('/pedido-cliente', [\App\Http\Controllers\OrderController::class, 'create'])->name('client.order.create');
Route::post('/pedido-cliente', [\App\Http\Controllers\OrderController::class, 'store'])->name('client.order.store');

require __DIR__.'/auth.php';

// Shopify Webhooks
Route::post('/webhook/shopify/orders/create', [\App\Http\Controllers\ShopifyWebhookController::class, 'handleOrderCreate'])->name('webhook.shopify.orders.create');
