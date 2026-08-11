<x-app-layout>
    <div class="mb-8 md:pt-4">
        <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Configuración</h2>
        <p class="text-[#757575] text-[13px] font-sans-custom">Ajustes generales del sistema</p>
    </div>

    <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB] max-w-3xl">
        <form class="space-y-6">
            <div>
                <h3 class="text-[16px] text-[#2C211A] font-semibold mb-4 border-b border-gray-100 pb-2">Información de la Empresa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-medium text-gray-700 mb-1">Nombre Comercial</label>
                        <input type="text" value="Verde Madera" class="w-full border border-[#EBEBEB] rounded-md text-[13px] text-gray-900 py-2 px-3 focus:ring-[#4C9156] focus:border-[#4C9156]">
                    </div>
                    <div>
                        <label class="block text-[12px] font-medium text-gray-700 mb-1">Correo de Contacto</label>
                        <input type="email" value="contacto@verdemadera.com.mx" class="w-full border border-[#EBEBEB] rounded-md text-[13px] text-gray-900 py-2 px-3 focus:ring-[#4C9156] focus:border-[#4C9156]">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-[16px] text-[#2C211A] font-semibold mb-4 border-b border-gray-100 pb-2">Integraciones</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded bg-green-100 text-green-800 flex items-center justify-center font-bold mr-4 text-xs">SH</div>
                            <div>
                                <h4 class="text-[14px] font-medium text-[#2C211A]">Shopify</h4>
                                <p class="text-[12px] text-gray-500">Sincronización de pedidos web</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-green-100 text-green-800 text-[10px] rounded uppercase font-bold">Conectado</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded bg-blue-100 text-blue-800 flex items-center justify-center font-bold mr-4 text-xs">NR</div>
                            <div>
                                <h4 class="text-[14px] font-medium text-[#2C211A]">ERP Nori</h4>
                                <p class="text-[12px] text-gray-500">Sincronización base de datos local</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 text-[10px] rounded uppercase font-bold">Pendiente</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md shadow-sm">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
