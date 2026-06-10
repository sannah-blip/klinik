<x-guest-layout>

<div class="grid lg:grid-cols-2 gap-0 min-h-[650px]">

    <!-- Panel Kiri -->
    <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-emerald-500 to-emerald-700 text-white p-12 rounded-l-3xl">

        <div class="mb-8">
            <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center text-4xl">
                🏥
            </div>
        </div>

        <h1 class="text-5xl font-bold leading-tight">
            Klinik Kampus
        </h1>

        <p class="mt-6 text-lg text-emerald-50">
            Sistem Manajemen Kunjungan Pasien berbasis web untuk mendukung pelayanan kesehatan yang cepat, aman, dan terintegrasi.
        </p>

        <div class="mt-10 space-y-4">

            <div class="flex items-center gap-3">
                <span class="text-2xl">📋</span>
                <span>Pencatatan kunjungan pasien digital</span>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-2xl">👨‍⚕️</span>
                <span>Data dokter dan riwayat pemeriksaan</span>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-2xl">🔒</span>
                <span>Akses aman berbasis role pengguna</span>
            </div>

        </div>

    </div>

    <!-- Panel Kanan -->
    <div class="flex items-center justify-center p-8 bg-white rounded-r-3xl">

        <div class="w-full max-w-md">

            <div class="text-center mb-8">

                <div class="lg:hidden text-5xl mb-4">
                    🏥
                </div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Selamat Datang
                </h2>

                <p class="text-slate-500 mt-2">
                    Silakan masuk ke akun Anda
                </p>

            </div>

            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Masukkan email"
                    >
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Masukkan password"
                    >
                </div>

                <div class="flex justify-between items-center mb-6">

                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-emerald-600"
                        >

                        <span class="ml-2 text-sm text-slate-600">
                            Ingat Saya
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm font-medium text-emerald-600 hover:text-emerald-700"
                        >
                            Lupa Password?
                        </a>
                    @endif

                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition"
                >
                    Masuk
                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>
```
