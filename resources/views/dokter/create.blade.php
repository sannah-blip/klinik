@extends('layouts.app')

@section('header_title', 'Tambah Dokter Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Dokter Spesialis</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi formulir di bawah untuk menambahkan dokter baru.</p>
        </div>
        <a href="{{ route('dokter.index') }}" 
           class="inline-flex items-center justify-center p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all duration-200"
           title="Kembali ke Daftar Dokter">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3 shadow-sm">
            <div class="p-1 bg-rose-100 text-rose-700 rounded-lg shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h5 class="text-sm font-bold text-rose-800">Mohon periksa kembali inputan Anda:</h5>
                <ul class="mt-1 text-xs text-rose-700 list-disc list-inside space-y-0.5 font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('dokter.store') }}" 
              method="POST" 
              class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Dokter</label>
                <input type="text"
                       name="nama_dokter"
                       value="{{ old('nama_dokter') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                       placeholder="Contoh: dr. Ahmad Fauzi, Sp.PD" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Spesialisasi / Poli</label>
                <input type="text"
                       name="spesialisasi"
                       value="{{ old('spesialisasi') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                       placeholder="Contoh: Penyakit Dalam" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jadwal Mulai Jaga</label>
                    <input type="datetime-local"
                           name="jadwal_mulai"
                           value="{{ old('jadwal_mulai') }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jadwal Selesai Jaga</label>
                    <input type="datetime-local"
                           name="jadwal_selesai"
                           value="{{ old('jadwal_selesai') }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200" required>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] rounded-xl shadow-lg shadow-emerald-600/10 transition-all duration-200">
                    Tambah Dokter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
