<!doctype html>
<html lang="en" class="h-full bg-slate-50/50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Klinik Kampus - Sistem Manajemen Kunjungan</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full text-slate-600 antialiased">
        
        <nav class="bg-white border-b border-slate-100 sticky top-0 z-40 shadow-sm shadow-slate-100/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-600 text-white rounded-xl shadow-sm shadow-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                            </svg>
                        </div>
                        <a class="text-base font-bold text-slate-800 tracking-tight hover:text-emerald-600 transition-colors duration-150" href="{{ route('kunjunganpasien.index') }}">
                            Klinik<span class="text-emerald-600 font-extrabold">Kampus</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Sistem Informasi Klinik v1.0
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            @if (session('success'))
                <div id="flash-notification" class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-3 shadow-sm transition-all duration-300 transform translate-y-0 opacity-100">
                    <div class="flex items-center gap-3">
                        <div class="p-1 bg-emerald-500 text-white rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-notification').remove()" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
            
        </main>

    </body>
</html>