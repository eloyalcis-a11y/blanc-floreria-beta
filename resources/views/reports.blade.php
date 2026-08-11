<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-end">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Reportes Financieros</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Métricas y KPIs del negocio</p>
        </div>
        <div class="flex gap-2">
            <select class="border border-[#EBEBEB] rounded-md text-[13px] text-[#2C211A] font-medium py-2 px-3 focus:ring-[#4C9156] focus:border-[#4C9156] bg-transparent">
                <option>Este mes</option>
                <option>Mes pasado</option>
                <option>Este año</option>
            </select>
            <button class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md shadow-sm">
                Descargar PDF
            </button>
        </div>
    </div>

    <!-- Charts Placeholder -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
            <h3 class="text-[14px] text-[#2C211A] font-semibold mb-4">Ventas por Canal</h3>
            <div class="h-[250px] w-full flex items-center justify-center bg-[#F5F4F0] rounded-xl border border-dashed border-gray-300">
                <div class="text-center">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <p class="text-[12px] text-gray-400 font-medium">Gráfico de Pastel (Próximamente)</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
            <h3 class="text-[14px] text-[#2C211A] font-semibold mb-4">Ingresos Mensuales</h3>
            <div class="h-[250px] w-full flex items-center justify-center bg-[#F5F4F0] rounded-xl border border-dashed border-gray-300">
                <div class="text-center">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <p class="text-[12px] text-gray-400 font-medium">Gráfico de Barras (Próximamente)</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
