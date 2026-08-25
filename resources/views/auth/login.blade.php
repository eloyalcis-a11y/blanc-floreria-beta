<x-guest-layout>
    <!-- Alpine.js is included in Laravel Breeze by default, we'll use it for interactivity -->
    <div x-data="{ name: '{{ old('name') }}', password: '', showPassword: false, get isValidName() { return this.name.length > 2; } }" class="w-full">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="relative group">
                <label for="name" class="block text-[12px] font-medium text-gray-500 mb-1 uppercase tracking-wider transition-colors group-focus-within:text-[#4A1525]">
                    Usuario
                </label>
                <div class="relative">
                    <input id="name" 
                           x-model="name"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-transparent py-3 pl-0 pr-10 text-gray-900 focus:border-[#4A1525] focus:ring-0 sm:text-sm transition-all duration-300 peer" 
                           type="text" 
                           name="name" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="Ej. admin" />
                    
                    <!-- Checkmark Icon (Animated) -->
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 text-[#4A1525] transition-all duration-300"
                         x-show="isValidName"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-50"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-50"
                         style="display: none;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative group mt-6">
                <div class="flex justify-between items-end mb-1">
                    <label for="password" class="block text-[12px] font-medium text-gray-500 uppercase tracking-wider transition-colors group-focus-within:text-[#4A1525]">
                        Contraseña
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-[11px] text-gray-400 hover:text-[#4A1525] transition-colors font-medium" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>
                
                <div class="relative">
                    <input id="password" 
                           x-model="password"
                           :type="showPassword ? 'text' : 'password'"
                           class="block w-full border-0 border-b-2 border-gray-200 bg-transparent py-3 pl-0 pr-10 text-gray-900 focus:border-[#4A1525] focus:ring-0 sm:text-sm transition-all duration-300"
                           name="password"
                           required 
                           autocomplete="current-password"
                           placeholder="••••••••" />
                           
                    <!-- Toggle Password Visibility -->
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute right-0 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4A1525] transition-colors focus:outline-none"
                            x-show="password.length > 0"
                            style="display: none;">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.53-3.06m7.85-2.22A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.39 2.76m-12.72 1.48l14.84-14.84M8.1 8.1a3 3 0 004.24 4.24"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-6">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <div class="relative flex items-center justify-center w-5 h-5">
                        <input id="remember_me" type="checkbox" class="peer sr-only" name="remember">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded transition-colors peer-checked:bg-[#4A1525] peer-checked:border-[#4A1525] group-hover:border-[#4A1525]"></div>
                        <svg class="absolute w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="ms-3 text-[13px] text-gray-500 font-medium group-hover:text-gray-800 transition-colors">Mantener sesión iniciada</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-[#4A1525] hover:bg-[#340f1a] focus:ring-4 focus:ring-gray-200 text-white py-3.5 rounded-lg text-[14px] font-medium transition-all shadow-sm hover:shadow-md flex justify-center items-center group">
                    <span>Acceder al Sistema</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
