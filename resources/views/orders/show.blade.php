<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-start">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#4A1525] transition-colors">
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
                
                
                
                'En proceso' => 'bg-[#E08544] text-white',
                'En ruta' => 'bg-amber-500 text-white',
                'Entregado y Pagado' => 'bg-[#4A1525] text-white',
            ];
            $class = $statusClasses[$order->status] ?? 'bg-gray-400 text-white';
        @endphp
        <div class="flex flex-col items-end gap-2">
            <span class="px-5 py-2 text-[13px] rounded-lg font-medium tracking-wide {{ $class }} shadow-sm">
                Estatus: {{ $order->status }}
            </span>
            <a href="{{ route('orders.edit', $order) }}" class="px-4 py-1.5 bg-white border border-gray-200 text-[#4A1525] rounded-md text-[13px] font-medium hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Editar Pedido
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main details -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Detalles del Cliente y Remitente -->
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-6 border-b border-gray-100 pb-3">Detalles del Cliente y Contacto</h3>
                
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Cliente / Comprador</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->client_name }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Empresa / Proyecto</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->company ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Teléfono de Contacto</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->client_phone ?: 'No proporcionado' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Correo Electrónico</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->client_email ?: 'No proporcionado' }}</p>
                    </div>
                    <div class="col-span-2 grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-100 mt-2">
                        <div>
                            <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider text-center">Nombre de Quien Recibe</p>
                            <p class="text-[16px] text-[#4A1525] font-bold text-center font-serif-custom">{{ $order->recipient_name ?: 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider text-center">Nombre del Remitente (Quien Envía)</p>
                        <p class="text-[16px] text-[#2C211A] font-medium text-center">{{ $order->sender_name ?: 'Mismo que el comprador' }}</p>
                    </div>
                </div>
            </div>

            <!-- Detalles del Arreglo -->
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-6 border-b border-gray-100 pb-3">Detalles del Arreglo</h3>
                
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div class="col-span-2">
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Descripción del Arreglo</p>
                        <p class="text-[16px] text-[#2C211A] font-medium">{{ $order->material }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Código del Modelo</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->product_code ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Cantidad</p>
                        <p class="text-[18px] text-[#2C211A] font-sans-custom font-medium">{{ $order->quantity }} <span class="text-sm font-normal text-gray-500">piezas</span></p>
                    </div>
                    
                    @if($order->notes)
                    <div class="col-span-2 bg-amber-50/50 p-4 rounded-lg border border-amber-100">
                        <p class="text-[11px] text-amber-800 font-semibold mb-1 uppercase tracking-wider">Notas / Especificaciones adicionales</p>
                        <p class="text-[14px] text-amber-900">{{ $order->notes }}</p>
                    </div>
                    @endif
                    
                    @if($order->dedication_message)
                    <div class="col-span-2 bg-pink-50/50 p-4 rounded-lg border border-pink-100">
                        <p class="text-[11px] text-pink-800 font-semibold mb-1 uppercase tracking-wider">Dedicatoria para la Tarjeta</p>
                        <p class="text-[14px] text-pink-900 italic font-serif">"{{ $order->dedication_message }}"</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Resumen Financiero y Logístico -->
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-6 border-b border-gray-100 pb-3">Resumen Financiero y Logística</h3>
                
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Método de Pago</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->payment_method ?: 'No especificado' }}</p>
                        @if($order->payment_method === 'Nómina')
                            <p class="text-[12px] text-gray-500 mt-1">RFC: <span class="font-medium text-gray-700">{{ $order->payroll_rfc }}</span></p>
                            <p class="text-[12px] text-gray-500">Área: <span class="font-medium text-gray-700">{{ $order->payroll_area }}</span></p>
                        @elseif($order->payment_method === 'Cuentas por cobrar')
                            <p class="text-[12px] text-gray-500 mt-1">Cobrar a: <span class="font-medium text-gray-700">{{ $order->accounts_receivable_entity }}</span></p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Gastos de Envío</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->shipping_cost ? 'MX$ ' . number_format($order->shipping_cost, 2) : 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Total del Pedido</p>
                        <p class="text-[20px] text-[#2C211A] font-sans-custom font-medium">MX$ {{ number_format($order->total_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Vendedor Responsable</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->salesperson ?: 'No asignado' }}</p>
                    </div>
                    
                    <div class="col-span-2 border-t border-gray-100 pt-6 mt-2"></div>
                    
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Fecha y Hora de Entrega</p>
                        <p class="text-[15px] text-[#2C211A] font-medium">
                            @if($order->delivery_date)
                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d \d\e M Y') }}
                            @else
                                Por definir
                            @endif
                            <br>
                            <span class="text-gray-500 text-sm">{{ $order->delivery_time ?: 'Horario no especificado' }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Ruta de Entrega</p>
                        @if($order->is_in_route)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-md text-sm font-medium border border-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                En Ruta de Entrega
                            </span>
                            @if($order->driver_name)
                                <p class="text-[13px] text-gray-600 mt-2">Con: <span class="font-medium text-gray-800">{{ $order->driver_name }}</span></p>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-600 rounded-md text-sm font-medium border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                En Taller / Espera
                            </span>
                        @endif
                    </div>
                    <div class="col-span-2">
                        <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Domicilio de Entrega</p>
                        @if($order->delivery_street || $order->delivery_neighborhood)
                            <p class="text-[15px] text-[#2C211A] font-medium mb-1">
                                {{ $order->delivery_street }}<br>
                                {{ $order->delivery_neighborhood }}{{ $order->delivery_zip ? ', C.P. '.$order->delivery_zip : '' }}
                            </p>
                            @if($order->delivery_references)
                                <p class="text-[13px] text-gray-500 italic mb-3">Ref: {{ $order->delivery_references }}</p>
                            @endif
                            
                            @php
                                $mapsQuery = urlencode(trim($order->delivery_street . ' ' . $order->delivery_neighborhood . ' ' . $order->delivery_zip));
                            @endphp
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $mapsQuery }}" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] text-white px-4 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Abrir en Google Maps
                            </a>
                        @else
                            <p class="text-[15px] text-[#2C211A] font-medium">{{ $order->delivery_address ?: 'No especificado' }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Administración Financiera -->
            <div class="mt-8 border-t border-gray-100 pt-6">
                <h3 class="text-[12px] font-bold text-[#4A1525] uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Administración Financiera y Facturación
                </h3>
                
                <form action="{{ route('orders.update-financials', $order) }}" method="POST" class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Precio de Venta ($)</label>
                            <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', $order->unit_price) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Cobro Adicional ($)</label>
                            <input type="number" step="0.01" name="extra_charge" value="{{ old('extra_charge', $order->extra_charge) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Gasto de Envío ($)</label>
                            <input type="number" step="0.01" name="shipping_cost" value="{{ old('shipping_cost', $order->shipping_cost) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Descuento Aplicado ($)</label>
                            <input type="number" step="0.01" name="discount" value="{{ old('discount', $order->discount) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                        </div>
                        <div class="col-span-1 md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Número de Ticket (Acuse de Sistema)</label>
                            <input type="text" name="ticket_number" value="{{ old('ticket_number', $order->ticket_number) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. TK-93847">
                        </div>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm">
                            <span class="text-gray-500 font-medium">Monto Total Calculado:</span>
                            <span class="text-lg font-bold text-[#2C211A] ml-2">${{ number_format(($order->unit_price ?? 0) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0) - ($order->discount ?? 0), 2) }}</span>
                        </div>
                        <button type="submit" class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">
                            Guardar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Actions & Files -->
        <div class="space-y-4">
            <!-- Referencia del arreglo -->
            @if($order->image_url)
            <div class="bg-white rounded-[14px] overflow-hidden shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-[12px] font-bold text-[#2C211A] uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Referencia
                    </h3>
                </div>
                
                @php
                    $isPdf = Str::endsWith(strtolower($order->image_url), '.pdf');
                @endphp
                
                <div class="p-2">
                    <a href="{{ $order->image_url }}" target="_blank" class="block rounded-lg overflow-hidden border border-gray-100 relative group">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-xs font-semibold bg-[#4A1525]/80 px-3 py-1.5 rounded-full backdrop-blur-sm">Ampliar Imagen</span>
                        </div>
                        @if($isPdf)
                            <div class="bg-gray-50 h-32 flex flex-col items-center justify-center text-center">
                                <span class="text-3xl mb-2">📄</span>
                                <span class="text-[11px] font-medium text-gray-700 px-4">Documento PDF</span>
                            </div>
                        @else
                            <img src="{{ $order->image_url }}" alt="Referencia" class="object-cover w-full h-48">
                        @endif
                    </a>
                </div>
            </div>
            @endif

            <!-- Comprobante de Pago -->
            @if($order->payment_proof_path)
            <div class="bg-white rounded-[14px] p-5 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[12px] font-bold text-[#2C211A] uppercase tracking-wider mb-4">Comprobante de Pago</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center text-red-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[12px] text-[#2C211A] font-medium truncate">Documento Adjunto</p>
                    </div>
                    <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-medium rounded-lg transition-colors shrink-0">
                        Ver
                    </a>
                </div>
            </div>
            @endif

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
                        <div class="mb-2">
                            <input type="text" name="driver_name" value="{{ $order->driver_name }}" placeholder="Nombre del chofer (opcional)" class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-[12px] focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <button type="submit" class="w-full bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            Marcar en Ruta
                        </button>
                    @endif
                </form>

                <form action="{{ route('orders.update-status', $order) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-2">
                            <select name="status" id="status-select" class="w-full border border-gray-200 rounded-lg px-2 py-2 text-[12px] focus:ring-[#4A1525] focus:border-[#4A1525] font-medium text-gray-700">
                                                                                                                                <option value="En proceso" {{ $order->status == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                <option value="En ruta" {{ $order->status == 'En ruta' ? 'selected' : '' }}>En ruta</option>
                                <option value="Entregado" {{ in_array($order->status, ['Entregado', 'Cerrado (Pagado)']) ? 'selected' : '' }}>Entregado (Al cliente)</option>
                                <option value="Cerrado (Pagado)" {{ $order->status == 'Cerrado (Pagado)' ? 'selected' : '' }}>Cerrado (Pagado y Terminado)</option>
                            </select>
                            <button type="submit" class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-3 py-2 rounded-lg text-[12px] font-medium transition-all shadow-sm flex items-center justify-center shrink-0" title="Actualizar Estatus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        
                        <div id="delivery-photo-container" class="{{ $order->status == 'Entregado y Pagado' ? '' : 'hidden' }} mt-2">
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Foto de Entrega (Opcional)</label>
                            <input type="file" name="delivery_photo" accept=".jpg,.jpeg,.png" class="w-full text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-100 hover:file:bg-gray-200">
                        </div>
                    </div>
                </form>
                
                <script>
                    document.getElementById('status-select').addEventListener('change', function() {
                        const container = document.getElementById('delivery-photo-container');
                        if (this.value === 'Entregado y Pagado') {
                            container.classList.remove('hidden');
                        } else {
                            container.classList.add('hidden');
                        }
                    });
                </script>
                <button class="w-full mb-3 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4 text-[#4A1525]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Orden
                </button>

                <!-- Botón para copiar enlace al cliente -->
                <button onclick="navigator.clipboard.writeText('{{ route('tracking.show', $order->order_number) }}').then(() => { alert('¡Enlace de seguimiento copiado al portapapeles!'); })" class="w-full bg-[#E5F5E5] hover:bg-[#D1EBD1] text-[#2E7D32] border border-[#A5D6A7] py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Copiar Enlace para WhatsApp
                </button>
                <button class="w-full bg-white hover:bg-red-50 text-red-600 border border-red-100 hover:border-red-200 py-2.5 rounded-lg text-[13px] font-medium transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Cancelar Pedido
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
