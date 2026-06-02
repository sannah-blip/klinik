@extends('layout.index')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Kunjungan Pasien</h1>
            <p class="text-sm text-slate-500 mt-1">Ubah formulir di bawah untuk memperbarui data kunjungan.</p>
        </div>
        <a href="{{ route('kunjungan.index') }}" 
           class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-colors duration-150"
           title="Kembali ke Daftar Kunjungan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3">
            <div class="p-1 bg-rose-100 text-rose-700 rounded-lg shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h5 class="text-sm font-semibold text-rose-800">Mohon periksa kembali inputan Anda:</h5>
                <ul class="mt-1 text-xs text-rose-700 list-disc list-inside space-y-0.5 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
        <form action="{{ route('kunjungan.update', $item->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Pasien</label>
                <input type="text"
                       name="nama_pasien"
                       value="{{ old('nama_pasien', $item->nama_pasien) }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                       placeholder="Contoh: Ahmad Fauzi" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pasien</label>
                    <div class="relative">
                        <select name="status"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                            <option value="Mahasiswa" {{ old('status', $item->status) == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Staf" {{ old('status', $item->status) == 'Staf' ? 'selected' : '' }}>Staf</option>
                            <option value="Umum" {{ old('status', $item->status) == 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Kunjungan</label>
                    <input type="date"
                           name="tanggal_kunjungan"
                           value="{{ old('tanggal_kunjungan', $item->tanggal_kunjungan) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keluhan Utama</label>
                <textarea name="keluhan_utama"
                          rows="3"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                          placeholder="Tuliskan keluhan..." required>{{ old('keluhan_utama', $item->keluhan_utama) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tindakan / Pemberian Obat</label>
                <textarea name="tindakan_obat"
                          rows="3"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                          placeholder="Tuliskan tindakan..." required>{{ old('tindakan_obat', $item->tindakan_obat) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokter Pemeriksa</label>
                <input type="text"
                       name="nama_dokter"
                       value="{{ old('nama_dokter', $item->nama_dokter) }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                       placeholder="Contoh: dr. Setiawan" required>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-xl shadow-sm shadow-emerald-200 transition-all duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection