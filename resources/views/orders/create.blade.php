<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8">
        <div class="mb-6">
            <h2 class="text-3xl font-serif text-[#3A2F25] mb-1">Nuevo Pedido</h2>
            <p class="text-gray-500 text-sm">Ingresa los datos del nuevo pedido.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ auth()->check() ? route('orders.store') : route('client.order.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente</label>
                        <input type="text" name="client_name" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                        <input type="text" name="company" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material / Descripción del Regalo</label>
                        <input type="text" name="material" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500" placeholder="Ej. Cuaderno + Pluma Bambú">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad (pzs)</label>
                        <input type="number" name="quantity" min="1" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                        <select name="payment_method" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <option value="Transferencia">Transferencia Bancaria</option>
                            <option value="Tarjeta">Tarjeta de Crédito / Débito</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Enlace de Imagen de Referencia (Opcional)</label>
                        <input type="url" name="image_url" placeholder="https://..." class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">Cancelar</a>
                    <button type="submit" class="bg-[#38533e] hover:bg-[#2d4232] text-white px-6 py-2 rounded-lg transition-colors">Guardar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
