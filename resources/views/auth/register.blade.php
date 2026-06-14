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
        min-height: 550px;
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
        margin-bottom: 16px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 6px;
        letter-spacing: 0.05em;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
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
        margin-top: 10px;
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

    .error-text {
        color: #e11d48;
        font-size: 12px;
        margin-top: 4px;
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
                    Daftar Akun <br><span style="color: #6ee7b7;">Mudah & Cepat.</span>
                </h1>
                <p style="font-size: 14px; color: #ecfdf5; line-height: 1.5; margin: 0;">
                    Buat akun baru untuk mengakses layanan rekam medis dan data kunjungan Klinik Kampus.
                </p>
            </div>

            <div style="font-size: 13px; color: #d1fae5; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <div style="margin-bottom: 8px;">• Akses Riwayat Kunjungan</div>
                <div>• Terintegrasi dengan Sistem Klinik</div>
            </div>
        </div>

        <div class="panel-right">
            
            <div style="margin-bottom: 20px;">
                <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Buat Akun Baru</h2>
                <p style="font-size: 14px; color: #64748b; margin: 4px 0 0 0;">Silakan isi formulir di bawah ini</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="form-control"
                            placeholder="Nama Lengkap Anda"
                        >
                    </div>
                    @if($errors->has('name'))
                        <div class="error-text">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <!-- Alamat Email -->
                <div class="form-group">
                    <label>Alamat Email</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="form-control"
                            placeholder="nama@gmail.com"
                        >
                    </div>
                    @if($errors->has('email'))
                        <div class="error-text">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Kata Sandi -->
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            name="password"
                            required
                            class="form-control"
                            placeholder="••••••••"
                        >
                    </div>
                    @if($errors->has('password'))
                        <div class="error-text">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div class="form-group">
                    <label>Konfirmasi Kata Sandi</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="form-control"
                            placeholder="••••••••"
                        >
                    </div>
                    @if($errors->has('password_confirmation'))
                        <div class="error-text">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Akun Baru
                </button>

                <div style="margin-top: 20px; text-align: center; font-size: 14px; color: #64748b;">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-link">Masuk di sini</a>
                </div>

            </form>

        </div>

    </div>
    
    <p class="footer-text">© {{ date('Y') }} Klinik Kampus. All rights reserved.</p>
    
</div>

</x-guest-layout>

