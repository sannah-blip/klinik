<x-guest-layout>

<style>
    .login-wrapper {
        width: 100%;
        font-family: 'Figtree', sans-serif;
        box-sizing: border-box;
    }

    .login-card {
        width: 100%;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        padding: 40px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 8px;
        letter-spacing: 0.05em;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        border-radius: 12px;
        font-size: 14px;
        box-sizing: border-box;
        transition: all 0.2s ease-in-out;
        color: #334155;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #10b981;
        outline: none;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
    }

    .flex-row-justify {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .btn-submit {
        width: 100%;
        background: #059669;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.25);
        transition: background 0.2s ease;
    }

    .btn-submit:hover {
        background: #047857;
    }

    .text-link {
        color: #059669;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .text-link:hover {
        text-decoration: underline;
        color: #047857;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        
        <div style="margin-bottom: 28px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; tracking: -0.02em;">Selamat Datang Kembali</h2>
            <p style="font-size: 14px; color: #64748b; margin: 6px 0 0 0;">Silakan masuk untuk mengelola data klinik</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Alamat Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="form-control"
                    placeholder="nama@gmail.com"
                >
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <label style="margin: 0;">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-link" style="font-size: 12px;">Lupa Password?</a>
                    @endif
                </div>
                <input
                    type="password"
                    name="password"
                    required
                    class="form-control"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex-row-justify">
                <label style="display: flex; align-items: center; color: #64748b; cursor: pointer; user-select: none;">
                    <input type="checkbox" name="remember" style="margin-right: 8px; accent-color: #059669; width: 16px; h: 16px;">
                    Ingat akun saya
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Masuk ke Dashboard
            </button>
        </form>

        <div style="margin-top: 24px; text-align: center; font-size: 14px; color: #64748b;">
            Belum punya akun? <a href="{{ route('register') }}" class="text-link">Daftar Akun</a>
        </div>

    </div>
</div>

</x-guest-layout>