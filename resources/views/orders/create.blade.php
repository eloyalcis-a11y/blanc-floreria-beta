<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <div class="mb-6">
            <h2 class="text-3xl font-serif text-[#3A2F25] mb-1">Nuevo Pedido</h2>
            <p class="text-gray-500 text-sm">Ingresa los datos del nuevo pedido.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ auth()->check() ? route('orders.store') : route('client.order.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Sección 1: Detalles del Cliente -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">1. Detalles del Cliente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente / Comprador *</label>
                            <input type="text" name="client_name" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa / Proyecto</label>
                            <input type="text" name="company" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto</label>
                            <input type="tel" name="client_phone" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                            <input type="email" name="client_email" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Remitente (Quien envía)</label>
                            <input type="text" name="sender_name" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Familia López, Tu amigo Juan, etc.">
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Detalles del Arreglo -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">2. Detalles del Arreglo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del Arreglo *</label>
                            <input type="text" name="material" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Ramo de 50 Rosas Rojas">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Código del Modelo</label>
                            <input type="text" name="product_code" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad (pzs) *</label>
                            <input type="number" name="quantity" min="1" value="1" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Referencia del Arreglo</label>
                            <input type="file" name="reference_image" accept=".jpg,.jpeg,.png,.pdf" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#4A1525] hover:file:bg-gray-200">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notas / Especificaciones adicionales</label>
                            <textarea name="notes" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. Rosas bien abiertas, sin papel coreano, etc."></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje o Dedicatoria para la Tarjeta</label>
                            <textarea name="dedication_message" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Logística -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">3. Logística y Entrega</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Entrega</label>
                            <input type="date" name="delivery_date" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Entrega (Rango)</label>
                            <input type="text" name="delivery_time" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="Ej. 10:00 AM - 1:00 PM">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Domicilio de Entrega</label>
                            <textarea name="delivery_address" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección 4: Detalles Financieros y Operativos -->
                <div>
                    <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">4. Finanzas y Operación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                            <select name="payment_method" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] bg-white">
                                <option value="Transferencia">Transferencia Bancaria</option>
                                <option value="Tarjeta">Tarjeta de Crédito / Débito</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Nómina">Nómina</option>
                                <option value="Billpocket">Billpocket</option>
                            </select>
                        </div>
                        
                        @if(!auth()->check() || auth()->user()->role === 'cliente')
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comprobante de Pago (Obligatorio) *</label>
                                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#4A1525] file:text-white hover:file:bg-[#340f1a]">
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gastos de Envío (MX$)</label>
                                <input type="number" step="0.01" min="0" name="shipping_cost" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vendedor Responsable</label>
                                <input type="text" name="salesperson" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-[#4A1525] focus:border-[#4A1525]">
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
