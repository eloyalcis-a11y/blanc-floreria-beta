<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
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
                  ->where('status', '!=', 'Cerrado (Pagado)')
                  ->orderBy('delivery_date', 'asc');
        } elseif ($request->filter === 'en_ruta') {
            $query->where('is_in_route', true)
                  ->where('status', '!=', 'Cerrado (Pagado)');
        } elseif ($request->filter === 'pendientes_pago') {
            $query->where('status', 'En proceso');
        } elseif ($request->filter === 'por_vencer') {
            $query->whereNotNull('delivery_date')
                  ->where('status', '!=', 'Cerrado (Pagado)')
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
    $pendientesCount = (clone $baseQuery)->where('status', 'En proceso')->count();
    $cotizadosCount = (clone $baseQuery)->where('status', 'Cotizado')->count();
    $enProduccionCount = (clone $baseQuery)->whereIn('status', ['En proceso', 'En ruta'])->count();
    $entregadosCount = (clone $baseQuery)->where('status', 'Cerrado (Pagado)')->count();

    // Próximos a entregar (hoy y próximos días) excluyendo entregados
    $upcomingOrders = (clone $baseQuery)
        ->where('status', '!=', 'Cerrado (Pagado)')
        ->whereNotNull('delivery_date')
        ->whereDate('delivery_date', '>=', now()->toDateString())
        ->whereDate('delivery_date', '<=', now()->addDays(2)->toDateString())
        ->orderBy('delivery_date', 'asc')
        ->get();

    // Obtener recordatorios próximos (3 días)
    $upcomingReminders = \App\Models\Reminder::all()->map(function ($reminder) {
        $reminder->next_date = \App\Http\Controllers\ReminderController::calculateNextDate($reminder->reminder_date, $reminder->frequency);
        $reminder->days_left = now()->startOfDay()->diffInDays($reminder->next_date, false);
        return $reminder;
    })->filter(function ($reminder) {
        return $reminder->days_left >= 0 && $reminder->days_left <= 3;
    })->sortBy('days_left')->values();

    return view('dashboard', compact('orders', 'allOrdersCount', 'pendientesCount', 'cotizadosCount', 'enProduccionCount', 'entregadosCount', 'upcomingOrders', 'upcomingReminders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tracking/{order_number}', [\App\Http\Controllers\TrackingController::class, 'show'])->name('tracking.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin/Ops Orders
    Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [\App\Http\Controllers\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/toggle-route', [\App\Http\Controllers\OrderController::class, 'toggleRoute'])->name('orders.toggle-route');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/financials', [\App\Http\Controllers\OrderController::class, 'updateFinancials'])->name('orders.update-financials');
    
    // Reportes
    Route::get('/reports/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
    
    // Notificaciones
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    
    // Módulos
    Route::view('/inicio', 'home')->name('home');
    Route::resource('/recordatorios', \App\Http\Controllers\ReminderController::class)->names('reminders')->parameters(['recordatorios' => 'reminder']);
    Route::get('/reportes', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';

// Shopify Webhooks e Integración
Route::post('/webhook/shopify/orders/create', [\App\Http\Controllers\ShopifyWebhookController::class, 'handleOrderCreate'])->name('webhook.shopify.orders.create');
Route::get('/shopify/install', [\App\Http\Controllers\ShopifyAuthController::class, 'install'])->name('shopify.install');
Route::get('/shopify/callback', [\App\Http\Controllers\ShopifyAuthController::class, 'callback'])->name('shopify.callback');
Route::get('/api/shopify/products', [\App\Http\Controllers\ShopifyProductController::class, 'search'])->name('shopify.products.search');
