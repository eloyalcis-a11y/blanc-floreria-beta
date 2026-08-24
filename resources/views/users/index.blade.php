<x-app-layout>
<div class="max-w-5xl mx-auto py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-[28px] font-bold text-[#2C211A] font-serif-custom tracking-tight">Usuarios</h1>
            <p class="text-gray-500 mt-1">Cuentas del personal que puede entrar al sistema.</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center bg-[#4A1525] hover:bg-[#3A101D] text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-sm gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-800 p-4 rounded-xl border border-green-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 text-red-800 p-4 rounded-xl border border-red-100">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white rounded-[20px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Rol</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-[#2C211A] text-[15px]">{{ $u->username }}</div>
                                <div class="text-[13px] text-gray-400 mt-0.5">{{ $u->name }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-3 py-1 rounded-full text-[12px] font-medium {{ $u->role === 'admin' ? 'bg-[#4A1525] text-white' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $roles[$u->role] ?? $u->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-[14px] text-gray-500">{{ $u->email ?: '—' }}</td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('users.edit', $u) }}" class="text-[#4A1525] hover:underline text-[14px] font-medium">Editar</a>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline ml-4"
                                          onsubmit="return confirm('¿Eliminar al usuario {{ $u->username }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-[14px] font-medium">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 px-6 text-center text-gray-400">Todavía no hay usuarios.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
