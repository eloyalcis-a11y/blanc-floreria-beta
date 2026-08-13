<x-app-layout>
    <div class="mb-8 md:pt-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Reportes y Finanzas</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Métricas, exportación y control administrativo</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('reports.export', request()->query()) }}" class="bg-[#217346] hover:bg-[#1a5c38] text-white px-5 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Descargar Excel
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <!-- Botones Rápidos de Fecha -->
            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Periodo</label>
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button type="submit" name="date_range" value="hoy" class="px-4 py-1.5 text-xs font-medium rounded-md transition-colors {{ $dateRange === 'hoy' ? 'bg-white shadow-sm text-[#4A1525]' : 'text-gray-500 hover:text-gray-700' }}">Hoy</button>
                    <button type="submit" name="date_range" value="semana" class="px-4 py-1.5 text-xs font-medium rounded-md transition-colors {{ $dateRange === 'semana' ? 'bg-white shadow-sm text-[#4A1525]' : 'text-gray-500 hover:text-gray-700' }}">Semana</button>
                    <button type="submit" name="date_range" value="mes" class="px-4 py-1.5 text-xs font-medium rounded-md transition-colors {{ $dateRange === 'mes' ? 'bg-white shadow-sm text-[#4A1525]' : 'text-gray-500 hover:text-gray-700' }}">Mes</button>
                </div>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Origen</label>
                <select name="source" class="w-full border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-[#4A1525] focus:border-[#4A1525] py-2" onchange="this.form.submit()">
                    <option value="Todos">Todos los orígenes</option>
                    <option value="página web" {{ request('source') === 'página web' ? 'selected' : '' }}>Página Web</option>
                    <option value="whatsapp" {{ request('source') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="tienda fisica" {{ request('source') === 'tienda fisica' ? 'selected' : '' }}>Tienda Física</option>
                </select>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Estado</label>
                <select name="status" class="w-full border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-[#4A1525] focus:border-[#4A1525] py-2" onchange="this.form.submit()">
                    <option value="Todos">Todos los estados</option>
                    <option value="Pendiente de Pago" {{ request('status') === 'Pendiente de Pago' ? 'selected' : '' }}>Pendiente de Pago</option>
                    <option value="Confirmado" {{ request('status') === 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="En producción" {{ request('status') === 'En producción' ? 'selected' : '' }}>En producción</option>
                    <option value="En ruta" {{ request('status') === 'En ruta' ? 'selected' : '' }}>En ruta</option>
                    <option value="Entregado" {{ request('status') === 'Entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            
            <input type="hidden" name="date_range" value="{{ $dateRange }}">
        </form>
    </div>

    <!-- Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <!-- Tarjeta 1 -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center">
            <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-1">Ingresos Totales</p>
            <p class="text-2xl text-[#2C211A] font-serif-custom">MX$ {{ number_format($totalIngresos, 2) }}</p>
        </div>
        <!-- Tarjeta 2 -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center">
            <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-1">Ticket Promedio</p>
            <p class="text-2xl text-[#2C211A] font-serif-custom">MX$ {{ number_format($ticketPromedio, 2) }}</p>
        </div>
        <!-- Tarjeta 3 -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center">
            <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-1">Total Envíos Cobrados</p>
            <p class="text-2xl text-[#4A1525] font-serif-custom">MX$ {{ number_format($totalEnvios, 2) }}</p>
        </div>
        <!-- Tarjeta 4 -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center">
            <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-1">Producto Estrella</p>
            <p class="text-xl text-[#2C211A] font-serif-custom truncate">{{ $topVendido ? $topVendido->product_code : 'N/A' }}</p>
            <p class="text-[10px] text-gray-400 mt-0.5">{{ $topVendido ? $topVendido->total . ' vendidos' : '' }}</p>
        </div>
    </div>

    <!-- Tabla Preview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-[13px] font-bold text-[#2C211A] uppercase tracking-wider">
                Previsualización de Pedidos ({{ $cantidadPedidos }})
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-4 pl-6 font-medium">Acuse</th>
                        <th class="p-4 font-medium">Cliente</th>
                        <th class="p-4 font-medium">Modelo</th>
                        <th class="p-4 font-medium">Origen</th>
                        <th class="p-4 font-medium">Ticket</th>
                        <th class="p-4 font-medium text-right pr-6">Total</th>
                    </tr>
                </thead>
                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                    @forelse($orders as $order)
                        @php
                            $totalOrder = ($order->unit_price ?? 0) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0) - ($order->discount ?? 0);
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 pl-6 font-medium text-[#4A1525]">{{ $order->order_number }}</td>
                            <td class="p-4">{{ $order->client_name }}</td>
                            <td class="p-4">{{ $order->product_code ?: $order->material }}</td>
                            <td class="p-4"><span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-bold uppercase">{{ $order->source ?? 'página web' }}</span></td>
                            <td class="p-4 text-gray-500">{{ $order->ticket_number ?? '-' }}</td>
                            <td class="p-4 pr-6 text-right font-medium">MX$ {{ number_format($totalOrder, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500 text-xs">
                                No se encontraron pedidos con estos filtros en este periodo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
