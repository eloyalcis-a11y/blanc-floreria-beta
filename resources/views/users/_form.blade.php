{{-- Campos compartidos por alta y edición. $user llega sólo al editar. --}}
@php($u = $user ?? null)

@if($errors->any())
    <div class="mb-6 bg-red-50 text-red-800 p-4 rounded-xl border border-red-100">
        <ul class="list-disc list-inside space-y-1 text-[14px]">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid md:grid-cols-2 gap-6">
    <div>
        <label for="username" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Usuario *</label>
        <input type="text" id="username" name="username" required autocomplete="off"
               value="{{ old('username', $u?->username) }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]"
               placeholder="Ej. operacion">
        <p class="text-[12px] text-gray-400 mt-1">Con esto entra al sistema. Letras, números, guiones.</p>
    </div>

    <div>
        <label for="name" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre *</label>
        <input type="text" id="name" name="name" required
               value="{{ old('name', $u?->name) }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]"
               placeholder="Ej. María López">
    </div>

    <div>
        <label for="role" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Rol *</label>
        <select id="role" name="role" required
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]">
            @foreach($roles as $valor => $etiqueta)
                <option value="{{ $valor }}" {{ old('role', $u?->role) === $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
            @endforeach
        </select>
        <p class="text-[12px] text-gray-400 mt-1">El rol define qué secciones ve en el menú.</p>
    </div>

    <div>
        <label for="email" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Correo</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', $u?->email) }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]"
               placeholder="Opcional">
        <p class="text-[12px] text-gray-400 mt-1">Opcional. Sólo se usa para recuperar la contraseña.</p>
    </div>

    <div>
        <label for="password" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">
            Contraseña {{ $u ? '' : '*' }}
        </label>
        <input type="password" id="password" name="password" autocomplete="new-password"
               {{ $u ? '' : 'required' }}
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]">
        <p class="text-[12px] text-gray-400 mt-1">
            {{ $u ? 'Déjala vacía para no cambiarla.' : 'Mínimo 8 caracteres.' }}
        </p>
    </div>

    <div>
        <label for="password_confirmation" class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Confirmar contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
               {{ $u ? '' : 'required' }}
               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-[#4A1525] focus:border-[#4A1525]">
    </div>
</div>

<div class="flex items-center gap-3 mt-8">
    <button type="submit" class="bg-[#4A1525] hover:bg-[#3A101D] text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-sm">
        {{ $u ? 'Guardar cambios' : 'Crear usuario' }}
    </button>
    <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-[#4A1525] px-4 py-2.5 font-medium">Cancelar</a>
</div>
