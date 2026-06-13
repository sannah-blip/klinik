@extends('layouts.app')

@section('header_title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">
    
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-emerald-900/10 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -right-20 -bottom-20 w-60 h-60 bg-emerald-500/20 rounded-full blur-xl"></div>
        
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Selamat Datang Kembali, {{ auth()->user()->name }}!
            </h1>
            <p class="text-emerald-100 text-sm md:text-base mt-2 leading-relaxed">
                Sistem Informasi Klinik Kampus siap digunakan. Pantau antrean, kelola riwayat pemeriksaan, dan berikan pelayanan kesehatan terbaik hari ini.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Antrean Hari Ini</span>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">12</h3>
            </div>
            <div class="text-xs text-emerald-600 font-semibold mt-4 flex items-center gap-1">
                <span>↑ 4 pasien baru</span> <span class="text-slate-400 font-normal">dari jam lalu</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pasien</span>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">148</h3>
            </div>
            <div class="text-xs text-slate-500 mt-4">
                Mahasiswa & Staff Kampus
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dokter Standby</span>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2">3</h3>
            </div>
            <div class="text-xs text-emerald-600 font-semibold mt-4">
                ● <span class="text-slate-500 font-normal">Semua poli aktif</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Selesai Diperiksa</span>
                <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">8 <span class="text-sm font-normal text-slate-400">/ 12</span></h3>
            </div>
            <div class="text-xs text-slate-400 mt-4">
                Tingkat penyelesaian: 66%
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-4">Akses Cepat Layanan</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <a href="{{ route('kunjunganpasien.create') }}" class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-emerald-500/30 hover:bg-emerald-50/20 transition group flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Daftarkan Kunjungan Baru</h4>
                        <p class="text-xs text-slate-400 mt-1">Input data pasien baru yang datang berobat ke klinik.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 mt-4 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Buka Form →
                    </span>
                </a>

                <a href="{{ route('kunjunganpasien.index') }}" class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-emerald-500/30 hover:bg-emerald-50/20 transition group flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Lihat Riwayat Kunjungan</h4>
                        <p class="text-xs text-slate-400 mt-1">Pantau rekam medis dan daftar riwayat kunjungan pasien.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 mt-4 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Buka Tabel →
                    </span>
                </a>

            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 mb-3">Informasi Klinik</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pastikan log sistem selalu diperbarui secara berkala demi integritas rekam medis kampus.
                </p>
                
                <div class="mt-4 space-y-2.5">
                    <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                        <span class="text-slate-500">Jam Operasional</span>
                        <span class="font-semibold text-slate-700">08:00 - 16:00</span>
                    </div>
                    <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                        <span class="text-slate-500">Kontak Darurat</span>
                        <span class="font-semibold text-slate-700">Ext-119</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-xl p-3 text-[11px] text-slate-500 text-center mt-4">
                Sistem aman terenkripsi berbasis peran pengguna.
            </div>
        </div>

    </div>

</div>
@endsection