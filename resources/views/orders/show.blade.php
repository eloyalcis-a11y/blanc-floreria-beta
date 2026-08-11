<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-start">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-emerald-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] leading-tight">Pedido #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h2>
                @if($order->source === 'Shopify')
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-[10px] rounded uppercase font-bold">Origen: Shopify</span>
                @elseif($order->source === 'Nori')
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-[10px] rounded uppercase font-bold">Origen: Nori</span>
                @endif
            </div>
            <p class="text-[#757575] text-[13px] font-sans-custom ml-9">Registrado el {{ $order->created_at->format('d \d\e M Y, h:i A') }}</p>
        </div>
        
        @php
            $statusClasses = [
                'Confirmado' => 'bg-[#4F75DA] text-white',
                'En producción' => 'bg-[#E08544] text-white',
                'Entregado' => 'bg-[#4C9156] text-white',
                'Cotizado' => 'bg-[#E9C441] text-white',
            ];
            $class = $statusClasses[$order->status] ?? 'bg-gray-400 text-white';
        @endphp
        <span class="px-5 py-2 text-[13px] rounded-lg font-medium tracking-wide {{ $class }} shadow-sm">
            Estatus: {{ $order->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-6 border-b border-gray-100 pb-3">Detalles del Cliente</h3>
                
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Nombre del Cliente</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->client_name }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Empresa / Proyecto</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->company ?: 'N/A' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Artículo(s) / Arreglo(s)</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->material ?: 'Varios' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-6 border-b border-gray-100 pb-3">Resumen Financiero y Logístico</h3>
                
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Cantidad</p>
                        <p class="text-[20px] text-[#2C211A] font-sans-custom font-light">{{ $order->quantity }} <span class="text-sm font-medium text-gray-500">piezas</span></p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Total del Pedido</p>
                        <p class="text-[20px] text-[#2C211A] font-sans-custom font-light">MX$ {{ number_format($order->total_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Método de Pago</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->payment_method ?: 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Fecha Estimada de Entrega</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">
                            @if($order->delivery_date)
                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d \d\e M Y') }}
                            @else
                                Por definir
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Ruta de Entrega</p>
                        @if($order->is_in_route)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-md text-sm font-medium border border-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                En Ruta de Entrega
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-600 rounded-md text-sm font-medium border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                En Taller / Espera
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-4">
            <div class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[12px] font-bold text-[#2C211A] uppercase tracking-wider mb-4">Acciones Rápidas</h3>
                
                <form action="{{ route('orders.toggle-route', $order) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    @if($order->is_in_route)
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Quitar de Ruta
                        </button>
                    @else
                        <button type="submit" class="w-full bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            Marcar en Ruta
                        </button>
                    @endif
                </form>

                <button class="w-full mb-3 bg-emerald-700 hover:bg-emerald-800 text-white py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editar Pedido
                </button>
                <button class="w-full mb-3 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Orden
                </button>
                <button class="w-full bg-white hover:bg-red-50 text-red-600 border border-red-100 hover:border-red-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Cancelar Pedido
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
