<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .font-serif-custom { font-family: 'Playfair Display', serif; }
            .font-sans-custom { font-family: 'Inter', sans-serif; }
            .bg-blanc {
                background-color: #FAFAFA;
                border-right: 1px solid #EBEBEB;
            }
        </style>
    </head>
    <body class="font-sans-custom antialiased text-gray-800 bg-[#F5F4F0]">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Sidebar for Desktop -->
            <aside class="hidden md:flex flex-col w-[260px] bg-blanc text-[#2C211A] shadow-[4px_0_24px_rgba(0,0,0,0.02)] min-h-screen relative z-10">
                <div class="flex items-center justify-center pt-10 pb-8">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Blanc Florería" class="w-32 mx-auto mb-2">
                    </div>
                </div>
                
                @auth
                <nav class="flex-1 px-4 space-y-2 mt-6">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('home') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Inicio
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Pedidos
                    </a>
                    @if(in_array(auth()->user()->role, ['admin', 'ventas', 'operacion']))
                    <a href="{{ route('clients.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('clients.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Clientes
                    </a>
                    <a href="{{ route('companies.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('companies.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Empresas
                    </a>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['admin', 'operacion']))
                    <a href="{{ route('materials.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('materials.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Materiales
                    </a>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['admin', 'ventas']))
                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('reports.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Reportes
                    </a>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('settings.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors mt-8">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ajustes
                    </a>
                    @endif
                    
                    <a href="{{ route('help.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('help.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ayuda
                    </a>

                    <!-- Notificaciones Link -->
                    <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('notifications.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Notificaciones
                        </div>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </nav>

                <div class="p-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-500 hover:text-[#4A1525] w-full text-left transition-colors">
                            <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
                @endauth
                @guest
                <nav class="flex-1 px-4 space-y-2 mt-4">
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-[#4A1525] hover:text-white transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Iniciar sesión
                    </a>
                </nav>
                @endguest
            </aside>

            <!-- Mobile Header (Placeholder) -->
            <div class="md:hidden bg-white text-[#2C211A] p-4 flex justify-between items-center shadow-md z-10 relative">
                <img src="{{ asset('images/logo.png') }}" alt="Blanc Florería" class="h-8">
                
                <div class="flex items-center gap-4">
                    <!-- Campana Mobile Link -->
                    <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-[#4A1525]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <button>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="p-6 md:p-12 max-w-[1200px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
            
            <!-- Mobile Bottom Navigation (as in mockup) -->
            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-[0_-4px_24px_rgba(0,0,0,0.05)] border-t flex justify-around p-3 z-50">
                <a href="{{ route('home') }}" class="flex flex-col items-center {{ request()->routeIs('home') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('home') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('home') ? 'font-medium mt-1' : '' }}">Inicio</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('dashboard') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('dashboard') ? 'font-medium mt-1' : '' }}">Pedidos</span>
                </a>
                <a href="{{ route('clients.index') }}" class="flex flex-col items-center {{ request()->routeIs('clients.*') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('clients.*') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('clients.*') ? 'font-medium mt-1' : '' }}">Clientes</span>
                </a>
                <a href="{{ route('materials.index') }}" class="flex flex-col items-center {{ request()->routeIs('materials.*') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('materials.*') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('materials.*') ? 'font-medium mt-1' : '' }}">Materiales</span>
                </a>
                <a href="{{ route('settings.index') }}" class="flex flex-col items-center {{ request()->routeIs('settings.*') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('settings.*') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('settings.*') ? 'font-medium mt-1' : '' }}">Perfil</span>
                </a>
            </nav>
        </div>
    </body>
</html>
