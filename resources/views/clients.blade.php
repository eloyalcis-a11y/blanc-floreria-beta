<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-end">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Directorio de Clientes</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Gestión de contactos y prospectos</p>
        </div>
        <button class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Cliente
        </button>
    </div>

    <div class="bg-white md:bg-transparent rounded-2xl md:rounded-none shadow-sm md:shadow-none border border-gray-100 md:border-none overflow-hidden mb-20 md:mb-0">
        <div class="p-5 md:p-0 border-b border-gray-100 md:border-none flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <h3 class="text-[22px] font-serif-custom text-[#2C211A]">Todos los Clientes</h3>
            <div class="relative w-full md:w-[280px]">
                <input type="text" placeholder="Buscar por nombre, correo o empresa..." class="pl-10 pr-4 py-2 border border-[#EBEBEB] rounded-md text-[13px] text-gray-500 w-full focus:ring-[#4C9156] focus:border-[#4C9156] bg-transparent">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto bg-[#F5F4F0]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-[#757575] font-semibold uppercase tracking-widest border-b border-[#EBEBEB]">
                        <th class="py-4 px-2">Cliente</th>
                        <th class="py-4 px-2">Empresa</th>
                        <th class="py-4 px-2">Correo</th>
                        <th class="py-4 px-2">Teléfono</th>
                        <th class="py-4 px-2 text-center">Pedidos Históricos</th>
                        <th class="py-4 px-2 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EBEBEB]">
                    <!-- Dummy Data -->
                    <tr class="hover:bg-white/50 transition-colors">
                        <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A] flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-[#E5EFDC] text-[#4C9156] flex items-center justify-center font-bold mr-3">LM</div>
                            Laura Mendoza
                        </td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">Grupo Horizonte</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">lmendoza@horizonte.com</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">+52 55 1234 5678</td>
                        <td class="py-5 px-2 text-center text-[13px] font-semibold text-[#2C211A]">4 pedidos</td>
                        <td class="py-5 px-2 text-center">
                            <button class="text-[#A2BA74] hover:text-[#4C9156]"><svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-white/50 transition-colors">
                        <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A] flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-[#FBE8D6] text-[#E08544] flex items-center justify-center font-bold mr-3">CR</div>
                            Carlos Ruiz
                        </td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">Innovatech S.A.</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">cruiz@innovatech.mx</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">+52 81 9876 5432</td>
                        <td class="py-5 px-2 text-center text-[13px] font-semibold text-[#2C211A]">1 pedido</td>
                        <td class="py-5 px-2 text-center">
                            <button class="text-[#A2BA74] hover:text-[#4C9156]"><svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="md:hidden space-y-4 bg-[#F5F4F0] p-4">
            <div class="bg-white rounded-[14px] p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#EBEBEB]">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-[#E5EFDC] text-[#4C9156] flex items-center justify-center font-bold mr-3 text-lg">LM</div>
                    <div>
                        <h4 class="text-[#2C211A] font-semibold text-[14px]">Laura Mendoza</h4>
                        <p class="text-[#757575] text-[12px]">Grupo Horizonte</p>
                    </div>
                </div>
                <p class="text-[12px] text-[#757575] mb-1">Correo: <span class="text-[#2C211A] font-medium">lmendoza@horizonte.com</span></p>
                <p class="text-[12px] text-[#757575] mb-4">Teléfono: <span class="text-[#2C211A] font-medium">+52 55 1234 5678</span></p>
            </div>
        </div>
    </div>
</x-app-layout>
