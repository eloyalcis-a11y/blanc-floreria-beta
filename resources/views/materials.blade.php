<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-end">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Inventario de Materiales</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Catálogo de productos y materias primas</p>
        </div>
        <button class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Material
        </button>
    </div>

    <div class="bg-white md:bg-transparent rounded-2xl md:rounded-none shadow-sm md:shadow-none border border-gray-100 md:border-none overflow-hidden mb-20 md:mb-0">
        <div class="p-5 md:p-0 border-b border-gray-100 md:border-none flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <h3 class="text-[22px] font-serif-custom text-[#2C211A]">Catálogo</h3>
            <div class="flex gap-3">
                <div class="relative w-full md:w-[280px]">
                    <input type="text" placeholder="Buscar material o SKU..." class="pl-10 pr-4 py-2 border border-[#EBEBEB] rounded-md text-[13px] text-gray-500 w-full focus:ring-[#4A1525] focus:border-[#4A1525] bg-transparent">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="hidden md:block overflow-x-auto bg-[#F5F4F0]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-[#757575] font-semibold uppercase tracking-widest border-b border-[#EBEBEB]">
                        <th class="py-4 px-2">SKU</th>
                        <th class="py-4 px-2">Material / Producto</th>
                        <th class="py-4 px-2">Categoría</th>
                        <th class="py-4 px-2 text-center">Stock</th>
                        <th class="py-4 px-2 text-center">Estatus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EBEBEB]">
                    <tr class="hover:bg-white/50 transition-colors">
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">MAT-001</td>
                        <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A]">Cuaderno + Pluma Bambú</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">Kits de Oficina</td>
                        <td class="py-5 px-2 text-center text-[13px] font-semibold text-[#2C211A]">150 pzs</td>
                        <td class="py-5 px-2 text-center"><span class="px-2.5 py-1 bg-green-100 text-green-800 text-[10px] rounded uppercase font-bold">Disponible</span></td>
                    </tr>
                    <tr class="hover:bg-white/50 transition-colors">
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">MAT-002</td>
                        <td class="py-5 px-2 text-[13px] font-medium text-[#2C211A]">Caja de Madera Grabada</td>
                        <td class="py-5 px-2 text-[13px] text-[#757575] font-medium">Empaques</td>
                        <td class="py-5 px-2 text-center text-[13px] font-semibold text-[#E08544]">12 pzs</td>
                        <td class="py-5 px-2 text-center"><span class="px-2.5 py-1 bg-orange-100 text-orange-800 text-[10px] rounded uppercase font-bold">Stock Bajo</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
