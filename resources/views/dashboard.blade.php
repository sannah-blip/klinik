<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-emerald-700">
                Dashboard Klinik Kampus
            </h2>

            <span class="text-sm text-slate-500">
                Selamat Datang, {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

                <div class="p-8">

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                            🏥
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-slate-800">
                                Sistem Manajemen Kunjungan Pasien
                            </h3>

                            <p class="text-slate-500">
                                Klinik Kampus
                            </p>
                        </div>
                    </div>

                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">

                        <h4 class="text-lg font-semibold text-emerald-700 mb-2">
                            Login Berhasil
                        </h4>

                        <p class="text-slate-600">
                            Selamat datang kembali,
                            <span class="font-semibold">
                                {{ auth()->user()->name }}
                            </span>.
                            Anda berhasil masuk ke sistem Klinik Kampus.
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
```
