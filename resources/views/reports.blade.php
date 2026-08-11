<x-app-layout>
    <div class="mb-8 md:pt-4 flex justify-between items-end">
        <div>
            <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Reportes Financieros</h2>
            <p class="text-[#757575] text-[13px] font-sans-custom">Métricas y KPIs del negocio</p>
        </div>
        <div class="flex gap-2">
            <select class="border border-[#EBEBEB] rounded-md text-[13px] text-[#2C211A] font-medium py-2 px-3 focus:ring-[#4A1525] focus:border-[#4A1525] bg-transparent">
                <option>Este mes</option>
                <option>Mes pasado</option>
                <option>Este año</option>
            </select>
            <button class="bg-[#4A1525] hover:bg-[#340f1a] text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-all shadow-sm hover:shadow-md shadow-sm">
                Descargar PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
            <h3 class="text-[14px] text-[#2C211A] font-semibold mb-4 uppercase tracking-wider">Métricas Principales</h3>
            <div class="space-y-6">
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Ingresos Totales (Entregados)</p>
                    <p class="text-[32px] text-[#2C211A] font-sans-custom font-light">MX$ {{ number_format($totalVentas ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-[#757575] font-semibold mb-1 uppercase tracking-wider">Pedidos en Curso</p>
                    <p class="text-[24px] text-[#2C211A] font-sans-custom font-light">{{ $pedidosActivos ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-[14px] p-6 shadow-[0_4px_16px_rgba(0,0,0,0.02)] border border-[#EBEBEB]">
            <h3 class="text-[14px] text-[#2C211A] font-semibold mb-4 uppercase tracking-wider">Top Clientes</h3>
            <div class="space-y-4">
                @if(isset($topClientes) && $topClientes->count() > 0)
                    @foreach($topClientes as $cliente)
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <div>
                            <p class="text-[13px] font-medium text-[#2C211A]">{{ $cliente->client_name }}</p>
                            <p class="text-[11px] text-gray-500">{{ $cliente->pedidos }} pedido(s)</p>
                        </div>
                        <p class="text-[14px] font-semibold text-[#4A1525]">MX$ {{ number_format($cliente->gastado, 2) }}</p>
                    </div>
                    @endforeach
                @else
                    <p class="text-[12px] text-gray-400 font-medium text-center py-4">No hay datos suficientes</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
