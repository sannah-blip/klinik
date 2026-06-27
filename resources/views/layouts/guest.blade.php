<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Klinik Kampus</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <div
            class="hidden lg:flex lg:w-[30%] bg-emerald-600 relative overflow-hidden flex-col p-12 text-white min-h-screen">

            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-800 z-0"></div>

            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl z-0"></div>
            <div class="absolute bottom-20 -right-10 w-60 h-60 bg-emerald-400/10 rounded-full blur-3xl z-0"></div>

            <div class="relative z-10 flex flex-col justify-between h-full w-full flex-1">

                <div class="space-y-5">
                    <div
                        class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center backdrop-blur-md text-2xl shadow-inner border border-white/10">
                        🏥
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight">Klinik Kampus</h1>
                        <p class="text-emerald-200 text-xs mt-1 font-semibold uppercase tracking-wider">Health Services
                        </p>
                    </div>
                </div>

                <div class="my-auto py-4 space-y-3.5 border-l-2 border-white/10 pl-4">
                    <div class="space-y-0.5">
                        <div class="text-2xl font-bold tracking-tight text-white">100%</div>
                        <div class="text-xs text-emerald-200 font-medium tracking-wide uppercase">Digital System</div>
                    </div>
                    <div class="space-y-0.5">
                        <div class="text-2xl font-bold tracking-tight text-white">24/7</div>
                        <div class="text-xs text-emerald-200 font-medium tracking-wide uppercase">Akses Data Real-time
                        </div>
                    </div>
                    <div class="space-y-0.5">
                        <div class="text-2xl font-bold tracking-tight text-white">Secure</div>
                        <div class="text-xs text-emerald-200 font-medium tracking-wide uppercase">Sistem Terintegrasi
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/20 pt-6 space-y-4">
                    <h2 class="text-xl font-bold leading-snug">
                        Layanan Medis <span class="text-emerald-300">Digital & Cepat.</span>
                    </h2>

                    <p class="text-xs text-emerald-100/75 leading-relaxed">
                        Sistem Manajemen Kunjungan Pasien untuk mendukung pelayanan kesehatan yang aman, modern, dan
                        terorganisir.
                    </p>

                    <div class="pt-1 space-y-2 text-xs text-emerald-100 font-medium">
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 shadow-sm animate-pulse"></span>
                            <p>Pencatatan Pasien Digital</p>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 shadow-sm animate-pulse"></span>
                            <p>Riwayat Pemeriksaan Real-time</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="w-full lg:w-[70%] flex flex-col justify-between items-center px-6 py-10 min-h-screen">

            <div class="hidden lg:block"></div>

            <div class="w-full max-w-md my-auto">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-slate-400 mt-8 tracking-wide">
                © {{ date('Y') }} Klinik Kampus. All rights reserved.
            </p>

        </div>

    </div>

</body>

</html>