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
                    <a href="{{ route('reminders.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('reminders.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Recordatorios
                    </a>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['admin', 'ventas']))
                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('reports.*') ? 'bg-[#4A1525] text-white rounded-xl font-medium shadow-sm' : 'text-gray-500 hover:text-[#4A1525]' }} transition-colors">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Reportes
                    </a>
                    @endif
                    

                    


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

                @endauth
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
                <a href="{{ route('reminders.index') }}" class="flex flex-col items-center {{ request()->routeIs('reminders.*') ? 'text-[#4A1525]' : 'text-gray-500 hover:text-[#4A1525]' }}">
                    <div class="{{ request()->routeIs('reminders.*') ? 'bg-[#4A1525]/10 p-2 rounded-xl' : 'p-2' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('reminders.*') ? 'font-medium mt-1' : '' }}">Alertas</span>
                </a>

            </nav>
        </div>
    </body>
</html>
