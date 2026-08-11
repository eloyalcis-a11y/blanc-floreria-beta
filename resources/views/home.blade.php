<x-app-layout>
    <div class="mb-8 md:pt-4">
        <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Hola de nuevo 👋</h2>
        <p class="text-[#757575] text-[13px] font-sans-custom">Bienvenido a tu panel principal</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-[14px] p-8 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] text-center">
            <div class="w-16 h-16 bg-[#F5F4F0] rounded-lg mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-[#A2BA74]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <h3 class="text-[18px] font-serif-custom text-[#2C211A] mb-2">Capturar Nuevo Pedido</h3>
            <p class="text-[13px] text-gray-500 mb-6">Ingresa manualmente una orden de venta corporativa.</p>
            <a href="{{ route('orders.create') }}" class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md shadow-sm">
                Crear Pedido
            </a>
        </div>

        <div class="bg-white rounded-[14px] p-8 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] text-center">
            <div class="w-16 h-16 bg-[#F5F4F0] rounded-lg mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-[#A2BA74]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <h3 class="text-[18px] font-serif-custom text-[#2C211A] mb-2">Control de Pedidos</h3>
            <p class="text-[13px] text-gray-500 mb-6">Revisa el estado de todas tus órdenes actuales.</p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md shadow-sm">
                Ver Pedidos
            </a>
        </div>
    </div>
</x-app-layout>
