<x-app-layout>
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-8">
        <a href="{{ route('reminders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#4A1525] transition-colors mb-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver a Recordatorios
        </a>
        <h1 class="text-[28px] font-bold text-[#2C211A] font-serif-custom tracking-tight">Nuevo Recordatorio</h1>
        <p class="text-gray-500 mt-1">Configura un evento importante para que el sistema te avise a tiempo.</p>
    </div>

    <form action="{{ route('reminders.store') }}" method="POST" class="bg-white rounded-[20px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 p-8">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Título del Evento *</label>
                <input type="text" name="title" required value="{{ old('title') }}" 
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#4A1525] focus:border-[#4A1525] bg-gray-50/50" 
                    placeholder="Ej. Cumpleaños de Juan Pérez">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Evento *</label>
                    <input type="date" name="reminder_date" required value="{{ old('reminder_date') }}" 
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#4A1525] focus:border-[#4A1525] bg-gray-50/50">
                    @error('reminder_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">¿Se repite? *</label>
                    <select name="frequency" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#4A1525] focus:border-[#4A1525] bg-gray-50/50">
                        <option value="anual" {{ old('frequency') == 'anual' ? 'selected' : '' }}>Cada Año (Cumpleaños / Aniversarios)</option>
                        <option value="mensual" {{ old('frequency') == 'mensual' ? 'selected' : '' }}>Cada Mes</option>
                        <option value="unico" {{ old('frequency') == 'unico' ? 'selected' : '' }}>No se repite (Evento Único)</option>
                    </select>
                    @error('frequency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas Adicionales (Opcional)</label>
                <textarea name="notes" rows="3" 
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#4A1525] focus:border-[#4A1525] bg-gray-50/50" 
                    placeholder="Ej. Le gustan los girasoles y chocolates.">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-[#4A1525] hover:bg-[#3A101D] text-white px-8 py-3 rounded-xl font-medium transition-colors shadow-sm">
                Guardar Recordatorio
            </button>
        </div>
    </form>
</div>
</x-app-layout>
