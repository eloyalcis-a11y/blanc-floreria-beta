<x-app-layout>
    <div class="mb-8 md:pt-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Reportes y Finanzas</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Métricas de ingresos (Solo contabiliza pedidos entregados y pagados)</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('reports.export', request()->query()) }}" class="px-5 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex items-center gap-2" style="background-color: #2E7D32; color: white;">
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
                    <option value="Shopify" {{ request('source') === 'Shopify' ? 'selected' : '' }}>Tienda Web (Shopify)</option>
                    <option value="Dashboard" {{ request('source') === 'Dashboard' ? 'selected' : '' }}>Manual (Equipo)</option>
                </select>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Método de Pago</label>
                <select name="payment_method" class="w-full border-gray-200 rounded-lg text-sm text-gray-700 focus:ring-[#4A1525] focus:border-[#4A1525] py-2" onchange="this.form.submit()">
                    <option value="Todos">Todos los métodos</option>
                    <option value="Shopify Payments" {{ request('payment_method') === 'Shopify Payments' ? 'selected' : '' }}>Shopify</option>
                    <option value="Transferencia Bancaria" {{ request('payment_method') === 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia</option>
                    <option value="Efectivo" {{ request('payment_method') === 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Terminal Billpocket" {{ request('payment_method') === 'Terminal Billpocket' ? 'selected' : '' }}>Billpocket</option>
                    <option value="Link de Pago" {{ request('payment_method') === 'Link de Pago' ? 'selected' : '' }}>Link de Pago</option>
                    <option value="Cuentas por cobrar" {{ request('payment_method') === 'Cuentas por cobrar' ? 'selected' : '' }}>CxC</option>
                    <option value="Nómina" {{ request('payment_method') === 'Nómina' ? 'selected' : '' }}>Nómina</option>
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

    <!-- Métricas por Método de Pago -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-[13px] font-bold text-[#2C211A] uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Resumen por Método de Pago
            </h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($paymentMethodTotals as $method => $total)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-1">{{ $method }}</p>
                        <p class="text-xl text-[#2C211A] font-serif-custom">MX$ {{ number_format($total, 2) }}</p>
                    </div>
                @empty
                    <div class="col-span-full text-center py-4 text-gray-500 text-sm">No hay datos de pagos para este periodo.</div>
                @endforelse
            </div>
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
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-3 pl-6 font-medium">#NOTA</th>
                        <th class="p-3 font-medium">MODELO</th>
                        <th class="p-3 font-medium">SOLICITANTE</th>
                        <th class="p-3 font-medium">FECHA ENT.</th>
                        <th class="p-3 font-medium text-center">CANT.</th>
                        <th class="p-3 font-medium"># TRANSITO</th>
                        <th class="p-3 font-medium">COSTO SAP</th>
                        <th class="p-3 font-medium text-right">P.U.</th>
                        <th class="p-3 font-medium text-right">SUBTOTAL</th>
                        <th class="p-3 font-medium text-right">15%</th>
                        <th class="p-3 font-medium">MÉTODO PAGO</th>
                        <th class="p-3 font-medium text-right font-bold text-black">TOTAL</th>
                        <th class="p-3 font-medium">#TICKET</th>
                        <th class="p-3 pr-6 font-medium">FECHA CORTE</th>
                    </tr>
                </thead>
                <tbody class="text-[12px] text-gray-700 divide-y divide-gray-50">
                    @forelse($orders as $order)
                        @php
                            $modelo = $order->product_code ?: $order->material;
                            $pu = floatval($order->unit_price ?? 0);
                            $qty = intval($order->quantity ?? 1);
                            $subtotal = $pu * $qty;
                            $extra = floatval($order->extra_charge ?? 0) + floatval($order->shipping_cost ?? 0) - floatval($order->discount ?? 0);
                            $total = $subtotal + $extra;
                            $deliveryDate = $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') : '';
                            $fechaCorte = $order->created_at->format('Y-m-d');
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 pl-6 font-medium text-[#4A1525]">{{ $order->order_number }}</td>
                            <td class="p-3">{{ Str::limit($modelo, 20) }}</td>
                            <td class="p-3">{{ Str::limit($order->client_name, 25) }}</td>
                            <td class="p-3 text-gray-500">{{ $deliveryDate }}</td>
                            <td class="p-3 text-center">{{ $qty }}</td>
                            <td class="p-3"></td>
                            <td class="p-3"></td>
                            <td class="p-3 text-right">MX$ {{ number_format($pu, 2) }}</td>
                            <td class="p-3 text-right text-gray-500">MX$ {{ number_format($subtotal, 2) }}</td>
                            <td class="p-3 text-right text-gray-500">MX$ {{ number_format($extra, 2) }}</td>
                            <td class="p-3"><span class="px-2 py-1 bg-gray-100 rounded text-[9px] font-bold uppercase">{{ $order->payment_method ?: 'N/E' }}</span></td>
                            <td class="p-3 text-right font-bold text-black">MX$ {{ number_format($total, 2) }}</td>
                            <td class="p-3 text-gray-500">{{ $order->ticket_number ?? 'N/A' }}</td>
                            <td class="p-3 pr-6 text-gray-400 text-[10px]">{{ $fechaCorte }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="p-8 text-center text-gray-500 text-xs">
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
