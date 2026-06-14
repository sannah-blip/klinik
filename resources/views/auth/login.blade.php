<x-guest-layout>

<style>
    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        background-color: #f1f5f9;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        font-family: 'Figtree', sans-serif;
        box-sizing: border-box;
    }

    .login-card {
        width: 100%;
        max-width: 850px;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        display: grid;
        grid-template-columns: 12fr;
        overflow: hidden;
        min-height: 500px;
    }

    /* Layout Responsif: Monitor Lebar */
    @media (min-width: 768px) {
        .login-card {
            grid-template-columns: 5fr 7fr;
        }
    }

    .panel-left {
        background: linear-gradient(135deg, #10b981, #047857);
        color: #ffffff;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    /* Sembunyikan panel kiri di hp */
    @media (max-width: 767px) {
        .panel-left {
            display: none;
        }
    }

    .panel-right {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 8px;
        letter-spacing: 0.05em;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px; /* Padding kiri disesuaikan karena ikon dihapus */
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        border-radius: 12px;
        font-size: 14px;
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #10b981;
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
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
        box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #047857;
    }

    .text-link {
        color: #059669;
        text-decoration: none;
        font-weight: 500;
    }

    .text-link:hover {
        text-decoration: underline;
    }

    .footer-text {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 24px;
    }
</style>

<div class="login-wrapper">
    
    <div class="login-card">
        
        <div class="panel-left">
            <div>
                <h3 style="margin: 0; font-size: 24px; font-weight: 700;">Klinik Kampus</h3>
                <p style="margin: 4px 0 0 0; font-size: 12px; color: #a7f3d0;">Health Services</p>
            </div>

            <div style="margin: 40px 0;">
                <h1 style="font-size: 28px; font-weight: 800; line-height: 1.2; margin-bottom: 12px;">
                    Layanan Medis <br><span style="color: #6ee7b7;">Digital & Cepat.</span>
                </h1>
                <p style="font-size: 14px; color: #ecfdf5; line-height: 1.5; margin: 0;">
                    Sistem Manajemen Kunjungan Pasien untuk mendukung pelayanan kesehatan yang aman dan terintegrasi.
                </p>
            </div>

            <div style="font-size: 13px; color: #d1fae5; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <div style="margin-bottom: 8px;">• Pencatatan Pasien Digital</div>
                <div>• Riwayat Pemeriksaan Real-time</div>
            </div>
        </div>

        <div class="panel-right">
            
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Selamat Datang Kembali</h2>
                <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Silakan masuk untuk mengelola data klinik</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Alamat Email</label>
                    <div class="input-wrapper">
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
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <label style="margin: 0;">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-link" style="font-size: 12px;">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            name="password"
                            required
                            class="form-control"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <div class="flex-row-justify">
                    <label style="display: flex; align-items: center; color: #64748b; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-right: 8px; accent-color: #059669;">
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
    
    <p class="footer-text">© 2026 Klinik Kampus. All rights reserved.</p>
    
</div>

</x-guest-layout>