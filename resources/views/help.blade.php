<x-app-layout>
    <div class="mb-8 md:pt-4">
        <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Centro de Ayuda</h2>
        <p class="text-[#757575] text-[13px] font-sans-custom">Soporte y documentación</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
            <!-- FAQ Item -->
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[16px] text-[#2C211A] font-semibold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4A1525]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    ¿Cómo busco un pedido específico?
                </h3>
                <p class="text-[13px] text-gray-600 leading-relaxed">
                    Puedes utilizar la barra de búsqueda superior en el panel de pedidos ("Dashboard"). Simplemente ingresa el número de orden, nombre del cliente, empresa o material y presiona Enter.
                </p>
            </div>
            
            <!-- FAQ Item -->
            <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
                <h3 class="text-[16px] text-[#2C211A] font-semibold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4A1525]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    ¿Qué significan las etiquetas Shopify y Nori?
                </h3>
                <p class="text-[13px] text-gray-600 leading-relaxed">
                    Indican el origen automático del pedido. "Shopify" significa que el cliente compró directamente en la tienda web. "Nori" indica que el pedido fue capturado por un vendedor en el punto de venta físico/ERP.
                </p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-[#4A1525] rounded-[14px] p-6 text-white shadow-md">
                <h3 class="text-[16px] font-semibold mb-2">¿Necesitas soporte técnico?</h3>
                <p class="text-[12px] text-gray-200 mb-6">Contacta al equipo de desarrollo para problemas con las integraciones o errores del sistema.</p>
                <button class="w-full bg-white text-[#4A1525] px-4 py-2 rounded-md text-[13px] font-bold transition-colors shadow-sm hover:bg-gray-100">
                    Crear Ticket
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
