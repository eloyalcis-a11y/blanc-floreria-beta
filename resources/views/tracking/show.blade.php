<x-guest-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif text-[#3A2F25]">Seguimiento de tu Pedido</h1>
            <p class="text-gray-500 mt-2">Orden #{{ $order->order_number }}</p>
        </div>

        @php
            $statuses = ['En proceso', 'En ruta', 'Entregado', 'Cerrado (Pagado)'];
            $currentIndex = array_search($order->status, $statuses);
            
            // Si está pendiente de pago o cotizado, no mostramos el progreso completo aún o lo mostramos diferente.
            // Para simplificar, asumiremos un flujo lineal desde Confirmado.
            $progressStatuses = ['En proceso', 'En ruta', 'Entregado', 'Cerrado (Pagado)'];
            $progressIndex = array_search($order->status, $progressStatuses);
        @endphp

        <!-- Barra de Progreso -->
        <div class="bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100 mb-8">
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100">
                    @if($progressIndex !== false)
                        @php
                            $percent = ($progressIndex / (count($progressStatuses) - 1)) * 100;
                        @endphp
                        <div style="width: {{ $percent }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#4A1525] transition-all duration-500"></div>
                    @endif
                </div>
                <div class="flex justify-between w-full">
                    @foreach($progressStatuses as $index => $status)
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full text-white {{ $progressIndex !== false && $progressIndex >= $index ? 'bg-[#4A1525]' : 'bg-gray-200 text-gray-400' }} transition-colors duration-500">
                                @if($progressIndex !== false && $progressIndex > $index)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="text-xs font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <span class="text-xs mt-2 font-medium {{ $progressIndex !== false && $progressIndex >= $index ? 'text-[#4A1525]' : 'text-gray-400' }}">{{ $status }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-8 text-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                <p class="text-sm text-gray-600">Estado actual:</p>
                <p class="text-xl font-bold text-[#4A1525] uppercase tracking-wide">{{ $order->status }}</p>
                @if($order->status === 'En ruta')
                    <p class="text-sm text-amber-700 mt-2 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        ¡Tu arreglo va en camino al domicilio{{ $order->driver_name ? ' con ' . $order->driver_name : '' }}!
                    </p>
                @endif
            </div>
        </div>

        @if($order->status === 'Entregado y Pagado' && $order->delivery_photo_path)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Foto de Entrega</h3>
                <div class="mt-4">
                    <img src="{{ Storage::url($order->delivery_photo_path) }}" alt="Foto de Entrega" class="w-full rounded-lg object-cover max-h-96">
                </div>
            </div>
        @endif

        <!-- Detalles Generales -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Detalles del Destinatario</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">A nombre de</p>
                    <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->client_name }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Remitente</p>
                    <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->sender_name ?: 'Anónimo' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Fecha Programada</p>
                    <p class="text-[15px] text-[#2C211A] font-medium">
                        {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d \d\e M Y') : 'Por definir' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Horario Programado</p>
                    <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->delivery_time ?: 'No especificado' }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Domicilio de Entrega</p>
                    <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->delivery_address ?: 'No especificado' }}</p>
                </div>
                
                @if($order->dedication_message)
                <div class="col-span-1 md:col-span-2 mt-4 bg-pink-50 p-4 rounded-xl border border-pink-100">
                    <p class="text-[11px] text-pink-800 font-semibold mb-1 uppercase tracking-wider text-center">Mensaje en la Tarjeta</p>
                    <p class="text-[16px] text-pink-900 italic font-serif text-center">"{{ $order->dedication_message }}"</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
