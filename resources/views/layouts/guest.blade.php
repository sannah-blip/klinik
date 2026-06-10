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

    <div class="min-h-screen flex">

        <!-- Kiri -->
        <div class="hidden lg:flex lg:w-1/2 bg-emerald-600 relative overflow-hidden">

            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-800"></div>

            <div class="relative z-10 flex flex-col justify-center px-16 text-white">

                <div class="mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                        🏥
                    </div>
                </div>

                <h1 class="text-5xl font-bold leading-tight">
                    Klinik Kampus
                </h1>

                <p class="mt-6 text-lg text-emerald-50 leading-relaxed">
                    Sistem Manajemen Kunjungan Pasien untuk mendukung
                    pelayanan kesehatan yang lebih cepat, modern,
                    dan terorganisir.
                </p>

                <div class="mt-10 flex gap-8 text-sm text-emerald-100">
                    <div>
                        <p class="text-3xl font-bold">100%</p>
                        <p>Digital</p>
                    </div>

                    <div>
                        <p class="text-3xl font-bold">24/7</p>
                        <p>Akses Data</p>
                    </div>

                    <div>
                        <p class="text-3xl font-bold">Secure</p>
                        <p>System</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Kanan -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10">

            <div class="w-full max-w-md">


                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

                    {{ $slot }}

                </div>

                <p class="text-center text-sm text-slate-400 mt-6">
                    © {{ date('Y') }} Klinik Kampus
                </p>

            </div>

        </div>

    </div>

</body>
</html>
```
