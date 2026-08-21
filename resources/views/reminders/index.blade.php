<x-app-layout>
<div class="max-w-5xl mx-auto py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-[28px] font-bold text-[#2C211A] font-serif-custom tracking-tight">Recordatorios</h1>
            <p class="text-gray-500 mt-1">Administra fechas importantes como cumpleaños y aniversarios.</p>
        </div>
        <a href="{{ route('reminders.create') }}" class="inline-flex items-center justify-center bg-[#4A1525] hover:bg-[#3A101D] text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-sm gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Recordatorio
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-800 p-4 rounded-xl border border-green-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[20px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Evento</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Frecuencia</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Próxima Fecha</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reminders as $reminder)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-[#2C211A] text-[15px]">{{ $reminder->title }}</div>
                                @if($reminder->notes)
                                    <div class="text-[13px] text-gray-400 mt-0.5 truncate max-w-[300px]">{{ $reminder->notes }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($reminder->frequency === 'anual')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Anual</span>
                                @elseif($reminder->frequency === 'mensual')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Mensual</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">Único</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-[14px] text-gray-700 font-medium">
                                    {{ \Carbon\Carbon::parse($reminder->next_date)->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-[12px] mt-1 font-medium
                                    {{ $reminder->days_left == 0 ? 'text-red-600' : ($reminder->days_left <= 3 ? 'text-amber-600' : 'text-gray-400') }}">
                                    @if($reminder->days_left == 0)
                                        ¡Es hoy!
                                    @elseif($reminder->days_left == 1)
                                        Mañana
                                    @else
                                        En {{ $reminder->days_left }} días
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('reminders.edit', $reminder) }}" class="p-2 text-gray-400 hover:text-[#4A1525] hover:bg-red-50 rounded-lg transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recordatorio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium mb-1">No hay recordatorios</p>
                                <p class="text-sm text-gray-400 mb-4">Crea tu primer recordatorio para fechas importantes.</p>
                                <a href="{{ route('reminders.create') }}" class="text-[#4A1525] hover:text-[#3A101D] font-medium text-sm">Crear Recordatorio &rarr;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
