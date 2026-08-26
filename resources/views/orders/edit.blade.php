<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <div class="mb-6">
            <h2 class="text-3xl font-serif text-[#3A2F25] mb-1">Editar Pedido {{ $order->order_number }}</h2>
            <p class="text-gray-500 text-sm">Edita los detalles del pedido.</p>
        </div>

@php
    $standardBlocks = [
        '10:00 AM - 12:00 PM',
        '12:00 PM - 02:00 PM',
        '02:00 PM - 04:00 PM',
        '04:00 PM - 06:00 PM',
        '06:00 PM - 08:00 PM',
        '08:00 PM - 10:00 PM',
        'Horario Especial / Fuera de horario'
    ];
    $isCustomTime = $order->delivery_time && !in_array($order->delivery_time, $standardBlocks);
    $initialOption = $isCustomTime ? 'Horario Especial / Fuera de horario' : $order->delivery_time;
@endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form x-data="{ 
                arrangementType: '{{ $order->arrangement_type ?: 'catalogo' }}',
                street: '{{ $order->delivery_street }}',
                neighborhood: '{{ $order->delivery_neighborhood }}',
                zip: '{{ $order->delivery_zip }}',
                paymentMethod: '{{ $order->payment_method ?: 'Transferencia Bancaria' }}',
                deliveryTimeOption: '{{ old('delivery_time', $initialOption) }}',
                searchQuery: '{{ $order->material }}',
                searchResults: [],
                isSearching: false,
                selectedProduct: null,
                selectedSku: '{{ $order->product_code }}',
                shopifyImageUrl: '{{ $order->image_url }}',
                async searchShopify() {
                    if (this.arrangementType !== 'catalogo') return;
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    this.isSearching = true;
                    try {
                        let res = await fetch('/api/shopify/products?q=' + encodeURIComponent(this.searchQuery));
                        this.searchResults = await res.json();
                    } catch(e) { console.error(e); }
                    this.isSearching = false;
                },
                selectProduct(product) {
                    this.selectedProduct = product;
                    this.searchQuery = product.title;
                    this.selectedSku = product.sku || '';
                    this.shopifyImageUrl = product.image || '';
                    this.searchResults = [];
                },
                get mapsUrl() {
                    let q = `${this.street} ${this.neighborhood} ${this.zip}`.trim();
                    if (!q) return '#';
                    return 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(q);
                }
            }" action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                    @method('PUT')
                
                <!-- Sección 1: Detalles del Cliente -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">1. Detalles del Cliente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente / Comprador *</label>
                            <input type="text" name="client_name" value="{{ old('client_name', $order->client_name) }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Quien paga/ordena">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de Quien Recibe</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', $order->recipient_name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Destinatario del arreglo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa / Proyecto</label>
                            <input type="text" name="company" value="{{ old('company', $order->company) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto</label>
                            <input type="tel" name="client_phone" value="{{ old('client_phone', $order->client_phone) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                            <input type="email" name="client_email" value="{{ old('client_email', $order->client_email) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Remitente (Quien envía)</label>
                            <input type="text" name="sender_name" value="{{ old('sender_name', $order->sender_name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Familia López, Tu amigo Juan, etc.">
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Detalles del Arreglo -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">2. Detalles del Arreglo</h3>
                    
                    <!-- Tipo de Arreglo (Selector) -->
                    <div class="mb-6 flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-3 border rounded-lg hover:bg-gray-50 transition-colors" :class="{ 'border-[#4A1525] bg-[#4A1525]/5': arrangementType === 'catalogo' }">
                            <input type="radio" name="arrangement_type" value="catalogo" x-model="arrangementType" class="text-[#4A1525] focus:ring-[#4A1525]">
                            <span class="text-sm font-medium text-gray-700">De Catálogo</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-3 border rounded-lg hover:bg-gray-50 transition-colors" :class="{ 'border-[#4A1525] bg-[#4A1525]/5': arrangementType === 'personalizado' }">
                            <input type="radio" name="arrangement_type" value="personalizado" x-model="arrangementType" class="text-[#4A1525] focus:ring-[#4A1525]">
                            <span class="text-sm font-medium text-gray-700">Diseño Personalizado</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Siempre visible pero etiqueta cambia -->
                        <div class="md:col-span-2 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span x-text="arrangementType === 'catalogo' ? 'Buscar modelo en Shopify *' : 'Descripción detallada del arreglo personalizado *'"></span>
                            </label>
                            
                            <!-- Input de búsqueda / material -->
                            <input type="text" name="material" value="{{ old('material', $order->material) }}" x-model="searchQuery" @input.debounce.500ms="searchShopify" required autocomplete="off" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Ramo de 50 Rosas Rojas">
                            
                            <!-- Cargando spinner -->
                            <div x-show="isSearching" class="absolute right-3 top-10 text-gray-400">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>

                            <!-- Resultados Dropdown -->
                            <div x-show="searchResults.length > 0" @click.away="searchResults = []" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <template x-for="product in searchResults" :key="product.id">
                                    <div @click="selectProduct(product)" class="flex items-center gap-3 p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0">
                                        <template x-if="product.image">
                                            <img :src="product.image" class="w-10 h-10 object-cover rounded-md border border-gray-100">
                                        </template>
                                        <template x-if="!product.image">
                                            <div class="w-10 h-10 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        </template>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900" x-text="product.title"></p>
                                            <p class="text-xs text-gray-500" x-text="'SKU: ' + (product.sku || 'N/A')"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <input type="hidden" name="shopify_image_url" :value="shopifyImageUrl">
                        </div>
                        
                        <!-- Solo catálogo -->
                        <div x-show="arrangementType === 'catalogo'" x-collapse>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Código del Modelo *</label>
                            <input type="text" name="product_code" value="{{ old('product_code', $order->product_code) }}" x-model="selectedSku" :required="arrangementType === 'catalogo'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] bg-gray-50" readonly>
                            <p class="text-xs text-green-600 mt-1 font-medium" x-show="selectedSku">✓ Sincronizado con Shopify</p>
                        </div>

                        <!-- Siempre visible -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad (pzs) *</label>
                            <input type="number" name="quantity" min="1" value="1" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>

                        <!-- Imagen de Referencia -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Referencia *</label>
                            
                            <!-- Para Personalizado -->
                            <div x-show="arrangementType === 'personalizado'" x-collapse>
                                @if($order->image_url)
                                    <p class="text-xs text-gray-500 mt-1">Ya cuenta con imagen. Sube otra solo si deseas reemplazarla.</p>
                                @endif
                                <input type="file" name="reference_image" accept=".jpg,.jpeg,.png,.pdf" :required="arrangementType === 'personalizado' && !'{{ $order->image_url }}'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#4A1525] hover:file:bg-gray-200">
                                <p class="text-xs text-gray-400 mt-1">Sube una imagen de inspiración o boceto del arreglo a armar.</p>
                            </div>

                            <!-- Para Catálogo -->
                            <div x-show="arrangementType === 'catalogo'" x-collapse>
                                <!-- Placeholder cuando no hay imagen -->
                                <div x-show="!shopifyImageUrl" class="w-full border-2 border-dashed border-gray-200 rounded-lg p-6 flex flex-col items-center justify-center text-gray-400 bg-gray-50 transition-all">
                                    <svg class="w-8 h-8 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm">La imagen se mostrará aquí automáticamente al seleccionar el modelo de Shopify</span>
                                </div>
                                <!-- Imagen seleccionada -->
                                <div x-show="shopifyImageUrl" style="display: none;" class="flex gap-4 items-center bg-gray-50 p-4 rounded-lg border border-gray-200 transition-all">
                                    <img :src="shopifyImageUrl" class="w-24 h-24 object-cover rounded-md shadow-sm border border-gray-100 bg-white">
                                    <div>
                                        <p class="text-sm font-bold text-green-700 flex items-center gap-1.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Imagen Sincronizada con Éxito
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">Esta es la foto que usaremos como referencia principal.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notas / Especificaciones adicionales</label>
                            <textarea name="notes" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Rosas bien abiertas, sin papel coreano, etc.">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje o Dedicatoria para la Tarjeta</label>
                            <textarea name="dedication_message" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">{{ old('dedication_message', $order->dedication_message) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Logística -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">3. Logística y Entrega</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Entrega</label>
                            <input type="date" name="delivery_date" value="{{ old('delivery_date', $order->delivery_date) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bloque de Entrega</label>
                            <select x-model="deliveryTimeOption" :name="deliveryTimeOption === 'Horario Especial / Fuera de horario' ? '' : 'delivery_time'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                                <option value="">Selecciona un bloque de entrega...</option>
                                <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                                <option value="12:00 PM - 02:00 PM">12:00 PM - 02:00 PM</option>
                                <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
                                <option value="04:00 PM - 06:00 PM">04:00 PM - 06:00 PM</option>
                                <option value="06:00 PM - 08:00 PM">06:00 PM - 08:00 PM</option>
                                <option value="08:00 PM - 10:00 PM">08:00 PM - 10:00 PM</option>
                                <option value="Horario Especial / Fuera de horario">Horario Especial / Fuera de horario</option>
                            </select>

                            <div x-show="deliveryTimeOption === 'Horario Especial / Fuera de horario'" x-cloak class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Especifica el horario exacto *</label>
                                <input type="text" :name="deliveryTimeOption === 'Horario Especial / Fuera de horario' ? 'delivery_time' : ''" :required="deliveryTimeOption === 'Horario Especial / Fuera de horario'" value="{{ $isCustomTime ? $order->delivery_time : '' }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. 1:15 PM o Lo más pronto posible">
                            </div>

                            <p class="text-xs text-gray-400 mt-1">Recuerda pedirlo con mínimo 2 horas de anticipación.</p>
                        </div>
                        <div class="md:col-span-2">
                            <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Chofer / Repartidor (Opcional)</label>
                            <input type="text" name="driver_name" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Juan Pérez" value="{{ old('driver_name', $order->driver_name ?? '') }}">
                        </div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Calle y Número *</label>
                            <input type="text" name="delivery_street" value="{{ old('delivery_street', $order->delivery_street) }}" x-model="street" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Av. Reforma 222, Int 4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Colonia / Fraccionamiento *</label>
                            <input type="text" name="delivery_neighborhood" value="{{ old('delivery_neighborhood', $order->delivery_neighborhood) }}" x-model="neighborhood" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Juárez">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Código Postal (Opcional)</label>
                            <input type="text" name="delivery_zip" value="{{ old('delivery_zip', $order->delivery_zip) }}" x-model="zip" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. 06600">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Referencias visuales o Link de Maps (Opcional)</label>
                            <textarea name="delivery_references" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Casa blanca con portón negro, frente al parque. O pega aquí el link de Maps.">{{ old('delivery_references', $order->delivery_references) }}</textarea>
                        </div>
                        <div class="md:col-span-2" x-show="street || neighborhood" x-collapse>
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Verificar Dirección</p>
                                    <p class="text-xs text-gray-500">Abre Maps para confirmar que la dirección sea correcta antes de guardar.</p>
                                </div>
                                <a :href="mapsUrl" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] text-white px-4 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Verificar en Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 4: Detalles Financieros y Operativos -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">4. Finanzas y Operación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                            <select name="payment_method" x-model="paymentMethod" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] bg-white">
                                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                                <option value="Depósito en efectivo">Depósito en efectivo</option>
                                <option value="Tarjeta">Tarjeta de Crédito / Débito</option>
                                <option value="Nómina">Nómina</option>
                                <option value="Cuentas por cobrar">Cuentas por cobrar</option>
                                <option value="Billpocket">Billpocket</option>
                            </select>
                        </div>
                        
                        <!-- Campos Dinámicos de Nómina -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" x-show="paymentMethod === 'Nómina'" x-collapse>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">RFC (Nómina) *</label>
                                <input type="text" name="payroll_rfc" value="{{ old('payroll_rfc', $order->payroll_rfc) }}" :required="paymentMethod === 'Nómina'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ingresa el RFC">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Área o Departamento *</label>
                                <input type="text" name="payroll_area" value="{{ old('payroll_area', $order->payroll_area) }}" :required="paymentMethod === 'Nómina'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Recursos Humanos">
                            </div>
                        </div>

                        <!-- Campos Dinámicos de Cuentas por cobrar -->
                        <div class="md:col-span-2" x-show="paymentMethod === 'Cuentas por cobrar'" x-collapse>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa / Persona a cobrar *</label>
                            <input type="text" name="accounts_receivable_entity" value="{{ old('accounts_receivable_entity', $order->accounts_receivable_entity) }}" :required="paymentMethod === 'Cuentas por cobrar'" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Nombre de la empresa o persona">
                        </div>
                        
                        @if(!auth()->check() || auth()->user()->role === 'cliente')
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comprobante de Pago (Obligatorio) *</label>
                                @if($order->payment_proof_path)
                                    <p class="text-xs text-gray-500 mt-1">Ya cuenta con comprobante. Sube otro solo si deseas reemplazarlo.</p>
                                @endif
                                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#4A1525] file:text-white hover:file:bg-[#340f1a]">
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gastos de Envío (MX$)</label>
                                <input type="number" step="0.01" min="0" name="shipping_cost" value="{{ old('shipping_cost', $order->shipping_cost) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vendedor Responsable</label>
                                <input type="text" name="salesperson" value="{{ old('salesperson', $order->salesperson) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comprobante de Pago (Si ya pagó)</label>
                                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#4A1525] hover:file:bg-gray-200">
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium">Cancelar</a>
                    <button type="submit" class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-8 py-2 rounded-lg transition-colors font-medium shadow-sm">Registrar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
