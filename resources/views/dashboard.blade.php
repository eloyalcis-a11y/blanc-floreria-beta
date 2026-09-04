<x-app-layout>
    <div class="mb-8 md:pt-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Control de Pedidos</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Gestión de pedidos de arreglos florales — Octubre 2024</p>
        </div>
        <div>
            <a href="{{ route('reports.export', request()->all()) }}" class="bg-white hover:bg-gray-50 px-4 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm flex items-center justify-center gap-2" style="color: #2E7D32; border: 1px solid #A5D6A7;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Descargar Reporte Excel
            </a>
        </div>
    </div>

    @if(isset($upcomingReminders) && $upcomingReminders->count() > 0)
        <!-- Reminders Widget -->
        <div class="mb-8 rounded-[16px] p-5 shadow-sm text-white flex flex-col md:flex-row gap-4 items-start md:items-center justify-between" style="background: linear-gradient(to right, #4A1525, #6b2038);">
            <div class="flex items-start gap-4">
                <div class="bg-white/10 p-3 rounded-xl mt-1">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2 text-white/90">Eventos Importantes (Próximos 3 días)</h3>
                    <ul class="space-y-1.5">
                        @foreach($upcomingReminders as $reminder)
                            <li class="flex items-center gap-2 text-[15px] text-white">
                                <span class="w-2 h-2 rounded-full {{ $reminder->days_left == 0 ? 'bg-red-400 animate-pulse' : 'bg-amber-400' }}"></span>
                                <span class="font-semibold">{{ $reminder->title }}</span> 
                                <span class="text-white/60 mx-1">&bull;</span>
                                @if($reminder->days_left == 0)
                                    <span class="text-red-300 font-bold tracking-wide uppercase text-xs">¡Es Hoy!</span>
                                @elseif($reminder->days_left == 1)
                                    <span class="text-amber-200">Mañana</span>
                                @else
                                    <span class="text-amber-100">Faltan {{ $reminder->days_left }} días</span>
                                @endif
                                @if($reminder->notes)
                                    <span class="text-white/60 ml-1 text-sm hidden md:inline">({{ Str::limit($reminder->notes, 40) }})</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-2 md:mt-0 ml-14 md:ml-0">
                <a href="{{ route('reminders.index') }}" class="inline-block bg-white/10 hover:bg-white/20 text-white text-[13px] font-medium px-4 py-2 rounded-lg transition-colors border border-white/10">Administrar</a>
            </div>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <a href="{{ route('dashboard', ['status' => 'Todos']) }}" class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] flex flex-col justify-between hover:shadow-md transition-shadow cursor-pointer block">
            <div>
                <h3 class="text-[11px] text-[#4A1525] font-semibold uppercase tracking-wider mb-2">Total Pedidos</h3>
                <p class="text-[40px] font-sans-custom font-light text-[#2C211A] leading-none">{{ $allOrdersCount ?? $orders->count() }}</p>
            </div>
            <p class="text-[11px] text-[#4A1525] mt-4 flex items-center font-medium">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                +12 este mes
            </p>
        </a>
        <a href="{{ route('dashboard', ['status' => 'Cotizado']) }}" class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] flex flex-col justify-between hover:shadow-md transition-shadow cursor-pointer block">
            <div>
                <h3 class="text-[11px] text-[#2C211A] font-semibold uppercase tracking-wider mb-2">Por Confirmar</h3>
                <p class="text-[40px] font-sans-custom font-light text-[#2C211A] leading-none">{{ $cotizadosCount ?? $orders->where('status', 'Cotizado')->count() }}</p>
            </div>
            <p class="text-[11px] text-[#757575] mt-4 flex items-center font-medium">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $cotizadosCount ?? 0 }} Cotizados
            </p>
        </a>
        <a href="{{ route('dashboard', ['status' => 'En producción']) }}" class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] flex flex-col justify-between hover:shadow-md transition-shadow cursor-pointer block">
            <div>
                <h3 class="text-[11px] text-[#2C211A] font-semibold uppercase tracking-wider mb-2">En Producción</h3>
                <p class="text-[40px] font-sans-custom font-light text-[#2C211A] leading-none">{{ $enProduccionCount ?? $orders->where('status', 'En producción')->count() }}</p>
            </div>
            <p class="text-[11px] text-[#757575] mt-4 flex items-center font-medium">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                Avance promedio 68%
            </p>
        </a>
        <a href="{{ route('dashboard', ['status' => 'Entregado y Pagado']) }}" class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] flex flex-col justify-between hover:shadow-md transition-shadow cursor-pointer block">
            <div>
                <h3 class="text-[11px] text-[#2C211A] font-semibold uppercase tracking-wider mb-2">Entregados</h3>
                <p class="text-[40px] font-sans-custom font-light text-[#2C211A] leading-none">{{ $entregadosCount ?? $orders->where('status', 'Entregado y Pagado')->count() }}</p>
            </div>
            <p class="text-[11px] text-[#4A1525] mt-4 flex items-center font-medium">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                +8 esta semana
            </p>
        </a>
    </div>

    <!-- Entregas para Hoy -->
    @if(isset($todayOrders) && $todayOrders->count() > 0)
    <div class="mb-8">
        <h3 class="text-[20px] font-serif-custom text-[#2C211A] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Entregas para Hoy
        </h3>
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-red-50 border-b border-red-100 text-[11px] font-bold text-red-700 uppercase tracking-wider">
                            <th class="px-5 py-4">Pedido</th>
                            <th class="px-5 py-4">Destinatario</th>
                            <th class="px-5 py-4">Día de Entrega</th>
                            <th class="px-5 py-4">Hora Estimada</th>
                            <th class="px-5 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-[13px] text-[#2C211A] font-medium">
                        @foreach($todayOrders as $todayOrder)
                            <tr class="hover:bg-gray-50 transition-colors group cursor-pointer" onclick="window.location='{{ route('orders.show', $todayOrder) }}'">
                                <td class="px-5 py-4 font-bold text-[#4A1525]">{{ $todayOrder->order_number }}</td>
                                <td class="px-5 py-4">{{ $todayOrder->client_name }}</td>
                                <td class="px-5 py-4 font-semibold text-red-600">HOY</td>
                                <td class="px-5 py-4">{{ $todayOrder->delivery_time ?: 'No especificado' }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-md text-xs font-bold border border-amber-200 uppercase tracking-wide">
                                        {{ $todayOrder->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Próximos a Entregar -->
    @if(isset($upcomingOrders) && $upcomingOrders->count() > 0)
    <div class="mb-8">
        <h3 class="text-[20px] font-serif-custom text-[#2C211A] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Próximos a Entregar (Próximas 48 hrs)
        </h3>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-[#757575] uppercase tracking-wider">
                            <th class="px-5 py-4">Pedido</th>
                            <th class="px-5 py-4">Destinatario</th>
                            <th class="px-5 py-4">Día de Entrega</th>
                            <th class="px-5 py-4">Hora Estimada</th>
                            <th class="px-5 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-[13px] text-[#2C211A] font-medium">
                        @foreach($upcomingOrders as $upOrder)
                            <tr class="hover:bg-gray-50 transition-colors group cursor-pointer" onclick="window.location='{{ route('orders.show', $upOrder) }}'">
                                <td class="px-5 py-4 font-bold text-[#4A1525]">{{ $upOrder->order_number }}</td>
                                <td class="px-5 py-4">{{ $upOrder->client_name }}</td>
                                <td class="px-5 py-4 font-semibold text-amber-700">
                                    {{ \Carbon\Carbon::parse($upOrder->delivery_date)->isToday() ? 'HOY' : (\Carbon\Carbon::parse($upOrder->delivery_date)->isTomorrow() ? 'Mañana' : \Carbon\Carbon::parse($upOrder->delivery_date)->format('d \d\e M')) }}
                                </td>
                                <td class="px-5 py-4">{{ $upOrder->delivery_time ?: 'No especificado' }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-md text-xs font-bold border border-amber-200 uppercase tracking-wide">
                                        {{ $upOrder->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Orders Section -->
    <div class="bg-white md:bg-transparent rounded-2xl md:rounded-none shadow-sm md:shadow-none border border-gray-100 md:border-none overflow-hidden mb-20 md:mb-0">
        <div class="p-5 md:p-0 border-b border-gray-100 md:border-none flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <h3 class="text-[22px] font-serif-custom text-[#2C211A]">Pedidos Recientes</h3>
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col md:flex-row gap-3 w-full justify-between" id="filter-form">
                <div class="flex gap-2 w-full md:w-auto">
                    <div class="relative flex-1 md:w-[280px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar pedido, cliente o empresa..." class="pl-10 pr-4 py-2 border border-[#EBEBEB] rounded-md text-[13px] text-gray-500 w-full focus:ring-[#4A1525] focus:border-[#4A1525] bg-transparent">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-md text-[13px] font-medium transition-colors border border-[#EBEBEB]">
                        Buscar
                    </button>
                </div>
                <div class="flex gap-2 justify-between w-full md:w-auto mt-2 md:mt-0">
                    <select name="status" onchange="document.getElementById('filter-form').submit()" class="border border-[#EBEBEB] rounded-md text-[13px] text-[#2C211A] font-medium py-2 pl-3 pr-8 focus:ring-[#4A1525] focus:border-[#4A1525] bg-transparent">
                        <option value="Todos" {{ request('status') == 'Todos' ? 'selected' : '' }}>Estado: Todos</option>
                                                                                                <option value="En proceso" {{ request('status') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="En ruta" {{ request('status') == 'En ruta' ? 'selected' : '' }}>En ruta</option>
                        <option value="Entregado" {{ request('status') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="Cerrado (Pagado)" {{ request('status') == 'Cerrado (Pagado)' ? 'selected' : '' }}>Cerrado (Pagado)</option>
                    </select>
                    <a href="{{ route('orders.create') }}" class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex items-center shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden md:inline">Nuevo Pedido</span>
                        <span class="md:hidden">Nuevo</span>
                    </a>
                </div>
            </form>
        </div>
        <div class="px-5 pb-4 md:px-0 md:pb-5 border-b border-gray-100 md:border-none flex gap-2 overflow-x-auto scrollbar-hide">
            <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider py-1.5 mr-2">Filtros Rápidos:</span>
            <a href="{{ route('dashboard', ['filter' => 'hoy']) }}" class="px-3 py-1.5 {{ request('filter') == 'hoy' ? 'bg-[#4A1525] text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }} rounded-full text-[11px] font-medium whitespace-nowrap transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Entregas Hoy
            </a>
            <a href="{{ route('dashboard', ['filter' => 'proximas']) }}" class="px-3 py-1.5 {{ request('filter') == 'proximas' ? 'bg-[#4A1525] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-[11px] font-medium whitespace-nowrap transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Próximas Entregas
            </a>
            <a href="{{ route('dashboard', ['filter' => 'por_vencer']) }}" class="px-3 py-1.5 {{ request('filter') == 'por_vencer' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }} rounded-full text-[11px] font-medium whitespace-nowrap transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Por Vencer
            </a>
            <a href="{{ route('dashboard', ['filter' => 'en_ruta']) }}" class="px-3 py-1.5 {{ request('filter') == 'en_ruta' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }} rounded-full text-[11px] font-medium whitespace-nowrap transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                En Ruta
            </a>
            @if(request()->has('filter'))
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 text-gray-500 hover:text-gray-700 text-[11px] font-medium whitespace-nowrap flex items-center transition-colors">
                    Limpiar Filtro
                </a>
            @endif
        </div>
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto bg-[#F5F4F0]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-[#757575] font-semibold uppercase tracking-widest border-b border-[#EBEBEB]">
                        <th class="py-4 px-2">Pedido</th>
                        <th class="py-4 px-2">Cliente</th>
                        <th class="py-4 px-2">Empresa</th>
                        <th class="py-4 px-2">Material</th>
                        <th class="py-4 px-2">Cantidad</th>
                        <th class="py-4 px-2">Precio Volumen</th>
                        <th class="py-4 px-2 text-center">Estatus</th>
                        <th class="py-4 px-2 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EBEBEB]">
                    @foreach($orders as $order)
                        <tr class="hover:bg-white/50 transition-colors">
                            <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A]">
                                @if($order->source === 'Shopify')
                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-800 text-[9px] rounded uppercase font-bold mr-1 block md:inline-block mb-1 md:mb-0">Shopify</span>
                                @elseif($order->source === 'Nori')
                                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 text-[9px] rounded uppercase font-bold mr-1 block md:inline-block mb-1 md:mb-0">Nori</span>
                                @endif
                                {{ $order->order_number }}
                            </td>
                            <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A]">{{ $order->client_name }}</td>
                            <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">{{ $order->company ?: 'N/A' }}</td>
                            <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">{{ $order->material ?: 'Varios' }}</td>
                            <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">{{ $order->quantity }} pzs</td>
                            <td class="py-5 px-2 text-[13px] font-semibold text-[#2C211A]">MX$ {{ number_format($order->total_price, 0) }}</td>
                            <td class="py-5 px-2 text-center">
                                @php
                                    $statusClasses = [
                                        'Pendiente de Pago' => 'bg-red-50 text-red-600 border border-red-200',
                                        'Cotizado' => 'bg-amber-50 text-amber-600 border border-amber-200',
                                        'Confirmado' => 'bg-blue-50 text-blue-600 border border-blue-200',
                                        'En producción' => 'bg-[#4A1525] text-white',
                                        'Entregado' => 'bg-[#4C9156] text-white',
                                        'Cerrado (Pagado)' => 'bg-[#4A1525] text-white',
                                    ];
                                    $badgeClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="px-4 py-1.5 text-[11px] rounded-lg font-medium tracking-wide {{ $badgeClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-5 px-2 text-center">
                                <a href="{{ route('orders.show', $order) }}" class="text-[#4A1525] hover:text-[#4A1525] inline-block">
                                    <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards View (Hidden on Desktop) -->
        <div class="md:hidden space-y-4 bg-[#F5F4F0] p-4">
            <!-- Filter Pills -->
            <div class="flex gap-2 overflow-x-auto pb-4 hide-scrollbar">
                <a href="{{ route('dashboard', ['status' => 'Todos']) }}" class="px-4 py-1.5 {{ request('status') == 'Todos' || !request('status') ? 'bg-[#4A1525] text-white' : 'bg-[#E8E8E8] text-[#757575]' }} text-[11px] rounded-lg font-medium whitespace-nowrap shadow-sm">Todos ({{ $allOrdersCount ?? 0 }})</a>
                <a href="{{ route('dashboard', ['status' => 'Pendiente de Pago']) }}" class="px-4 py-1.5 {{ request('status') == 'Pendiente de Pago' ? 'bg-[#4A1525] text-white' : 'bg-[#E8E8E8] text-[#757575]' }} text-[11px] rounded-lg font-medium whitespace-nowrap shadow-sm">Pendiente ({{ $pendientesCount ?? 0 }})</a>
                <a href="{{ route('dashboard', ['status' => 'Cotizado']) }}" class="px-4 py-1.5 {{ request('status') == 'Cotizado' ? 'bg-[#4A1525] text-white' : 'bg-[#E8E8E8] text-[#757575]' }} text-[11px] rounded-lg font-medium whitespace-nowrap shadow-sm">Cotizado ({{ $cotizadosCount ?? 0 }})</a>
                <a href="{{ route('dashboard', ['status' => 'Confirmado']) }}" class="px-4 py-1.5 {{ request('status') == 'Confirmado' ? 'bg-[#4A1525] text-white' : 'bg-[#E8E8E8] text-[#757575]' }} text-[11px] rounded-lg font-medium whitespace-nowrap shadow-sm">Confirmado</a>
                <a href="{{ route('dashboard', ['status' => 'En producción']) }}" class="px-4 py-1.5 {{ request('status') == 'En producción' ? 'bg-[#4A1525] text-white' : 'bg-[#E8E8E8] text-[#757575]' }} text-[11px] rounded-lg font-medium whitespace-nowrap shadow-sm">En producción ({{ $enProduccionCount ?? 0 }})</a>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white rounded-[14px] p-8 text-center text-gray-500 text-sm">
                    No se encontraron pedidos con estos filtros.
                </div>
            @endif

            @foreach($orders as $order)
                <div class="bg-white rounded-[14px] p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#EBEBEB]">
                    <div class="flex justify-between items-start mb-3">
                        @php
                            $statusClasses = [
                                'Pendiente de Pago' => 'bg-red-50 text-red-600',
                                'Cotizado' => 'bg-amber-50 text-amber-600',
                                'Confirmado' => 'bg-[#FAFAFA] text-[#4A1525]',
                                'En producción' => 'bg-[#FAFAFA] text-[#4A1525]',
                                'Entregado' => 'bg-[#F2FDF4] text-[#4C9156]',
                                'Cerrado (Pagado)' => 'bg-[#FAFAFA] text-[#4A1525]',
                            ];
                            $mobileClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                            
                            $sourceIcon = $order->source === 'Shopify' ? '<span class="px-1.5 py-0.5 bg-green-100 text-green-800 text-[9px] rounded uppercase font-bold mr-1">Shopify</span>' : ($order->source === 'Nori' ? '<span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 text-[9px] rounded uppercase font-bold mr-1">Nori</span>' : '');
                        @endphp
                        <div class="flex items-center gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="text-[#2C211A] font-semibold text-[13px] hover:text-[#4A1525]">{!! $sourceIcon !!}{{ $order->order_number }}</a>
                            <span class="w-1 h-1 rounded-lg bg-gray-300"></span>
                            <span class="px-3 py-1 text-[11px] rounded-lg font-bold tracking-wide {{ $mobileClass }}">{{ $order->status }}</span>
                        </div>
                    </div>
                    <p class="text-[12px] text-[#757575] mb-1">Cliente: <span class="text-[#2C211A] font-medium">{{ $order->client_name }}</span></p>
                    <p class="text-[12px] text-[#757575] mb-4">Empresa: <span class="text-[#2C211A] font-medium">{{ $order->company ?: 'N/A' }}</span></p>
                    
                    <div class="flex justify-between items-end pt-3 border-t border-gray-100 mb-4">
                        <div>
                            <p class="text-[11px] text-[#2C211A] font-semibold mb-1">Material:</p>
                            <p class="text-[12px] text-[#757575] font-medium">{{ $order->material ?: 'Varios' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[11px] text-[#2C211A] font-semibold mb-1">Cantidad:</p>
                            <p class="text-[12px] text-[#757575] font-medium">{{ $order->quantity }} pzs</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[11px] text-[#2C211A] font-semibold mb-1">Precio volumen:</p>
                            <p class="text-[12px] text-[#2C211A] font-semibold">MX$ {{ number_format($order->total_price, 0) }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-[11px] text-[#2C211A] font-medium mb-2">Estatus: <span class="{{ str_contains($mobileClass, 'text-[#4A1525]') ? 'text-[#4A1525]' : 'text-[#E08544]' }} font-semibold">{{ $order->status }}</span> — Detalle logístico</p>
                        <div class="w-full bg-[#EBEBEB] rounded-lg h-1.5">
                            <div class="{{ str_contains($mobileClass, 'text-[#4A1525]') ? 'bg-[#4A1525]' : 'bg-[#E08544]' }} h-1.5 rounded-lg" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-4 md:mt-4 text-[12px] text-[#757575]">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
