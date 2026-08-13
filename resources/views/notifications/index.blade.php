<x-app-layout>
    <div class="mb-8 md:pt-4">
        <h2 class="text-[32px] font-serif-custom font-normal text-[#2C211A] mb-1 leading-tight">Centro de Notificaciones</h2>
        <p class="text-[#757575] text-[13px] font-sans-custom">Historial de alertas y nuevos pedidos recibidos</p>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-[#EBEBEB] overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-[14px] font-bold text-[#2C211A] uppercase tracking-wider flex items-center gap-2">
                <svg class="w-5 h-5 text-[#4A1525]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Todas las Notificaciones
            </h3>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}" class="block p-6 hover:bg-gray-50 transition-colors {{ is_null($notification->read_at) ? 'bg-[#fdf8f9]' : 'bg-white' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <!-- Icono de Estado -->
                            <div class="flex-shrink-0 mt-1">
                                @if(is_null($notification->read_at))
                                    <div class="w-10 h-10 rounded-full bg-[#4A1525] flex items-center justify-center shadow-md">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Contenido -->
                            <div>
                                <h4 class="text-[15px] font-semibold {{ is_null($notification->read_at) ? 'text-[#4A1525]' : 'text-gray-700' }} mb-1">
                                    {{ $notification->data['message'] ?? 'Notificación' }}
                                    @if(is_null($notification->read_at))
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-wide">
                                            Nueva
                                        </span>
                                    @endif
                                </h4>
                                <p class="text-[13px] text-gray-500 mb-2">Se ha registrado una nueva orden #{{ $notification->data['order_number'] ?? '' }} en el sistema que requiere tu atención.</p>
                                <div class="flex items-center gap-4 text-[12px] text-gray-400 font-medium">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <span>{{ $notification->created_at->format('d M, Y - h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hidden sm:block">
                            <span class="inline-flex items-center justify-center p-2 rounded-lg border {{ is_null($notification->read_at) ? 'border-[#4A1525]/20 text-[#4A1525] hover:bg-[#4A1525] hover:text-white' : 'border-gray-200 text-gray-400 hover:bg-gray-50' }} transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tu buzón está vacío</h3>
                    <p class="text-sm text-gray-500">Aún no has recibido ninguna notificación en el sistema.</p>
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
