<x-guest-layout>

<div class="w-full max-w-md mx-auto">

    <div class="text-center mb-8">

        <div class="text-5xl mb-4">
            🔑
        </div>

        <h2 class="text-3xl font-bold text-slate-800">
            Lupa Password?
        </h2>

        <p class="text-slate-500 mt-3 leading-relaxed">
            Masukkan alamat email yang terdaftar pada akun Anda.
            Kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

    </div>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>

            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="Masukkan email Anda"
                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>

        <button
            type="submit"
            class="w-full mt-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition"
        >
            Kirim Link Reset Password
        </button>

        <div class="mt-5 text-center">

            <a
                href="{{ route('login') }}"
                class="text-sm font-medium text-emerald-600 hover:text-emerald-700"
            >
                ← Kembali ke Login
            </a>

        </div>

    </form>

</div>

</x-guest-layout>
```
