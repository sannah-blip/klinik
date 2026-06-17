<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Klinik Kampus</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200/80 p-6 flex flex-col justify-between transition-transform duration-300 ease-in-out md:static md:translate-x-0 shrink-0">
            
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight">Klinik Kampus</span>
                        <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase mt-0.5">Dashboard System</span>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-slate-600">
                        ✕
                    </button>
                </div>

                <nav class="space-y-1.5">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span>📊</span> Dashboard
                    </a>

                    @if(auth()->user()->role === 'Admin')
                    <a href="{{ route('kunjunganpasien.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('kunjunganpasien.index') || request()->routeIs('kunjunganpasien.edit') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span>📋</span> Data Kunjungan
                    </a>

                    <a href="{{ route('dokter.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('dokter.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span>🩺</span> Kelola Dokter
                    </a>

                    <a href="{{ route('clinic-info.edit') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('clinic-info.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span>🏢</span> Informasi Klinik
                    </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span>👤</span> Pengaturan Profil
                    </a>
                </nav>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <div class="flex flex-col mb-3 px-2">
                    <span class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</span>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-all duration-200">
                        <span>🚪</span> Keluar Aplikasi
                    </button>
                </form>
            </div>

        </div>

        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-900/20 backdrop-blur-sm md:hidden"></div>

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <header class="bg-white border-b border-slate-200/80 px-6 py-4 flex items-center justify-between shrink-0 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-600">
                        ☰
                    </button>
                    
                    <h2 class="text-lg font-bold text-slate-800">
                        @yield('header_title', 'Sistem Informasi Klinik')
                    </h2>
                </div>

                <div class="text-sm font-medium text-slate-500">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </header>

            <main class="p-6 md:p-8 flex-1">
                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>