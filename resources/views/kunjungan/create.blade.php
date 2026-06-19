@extends('layouts.app')

@section('header_title', 'Registrasi Kunjungan Pasien')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Kunjungan Pasien</h1>
            <p class="text-sm text-slate-500 mt-1">Isi formulir di bawah untuk mencatat data kunjungan baru.</p>
        </div>
        <a href="{{ route('kunjunganpasien.index') }}" 
           class="inline-flex items-center justify-center p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all duration-200"
           title="Kembali ke Daftar Kunjungan">
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
        <form action="{{ route('kunjunganpasien.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Pasien</label>
                <input type="text"
                       name="nama_pasien"
                       value="{{ old('nama_pasien') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                       placeholder="Contoh: Ahmad Fauzi" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pasien</label>
                    <div class="relative">
                        <select name="status"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status</option>
                            <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Staf" {{ old('status') == 'Staf' ? 'selected' : '' }}>Staf</option>
                            <option value="Umum" {{ old('status') == 'Umum' ? 'selected' : '' }}>Umum</option>
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
                           value="{{ old('tanggal_kunjungan') ?? date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Kunjungan</label>
                <div class="relative">
                    <select name="kategori_kunjungan_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_kunjungan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keluhan Utama</label>
                <textarea name="keluhan_utama"
                          rows="3"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 resize-none"
                          placeholder="Tuliskan keluhan atau gejala yang dirasakan pasien..." required>{{ old('keluhan_utama') }}</textarea>
            </div>

            @if(auth()->user()->role === 'Admin')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tindakan Medis</label>
                    <textarea name="tindakan"
                              rows="3"
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 resize-none"
                              placeholder="Tuliskan tindakan medis yang dilakukan...">{{ old('tindakan') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pemberian Obat / Resep</label>
                    <textarea name="pemberian_obat"
                              rows="3"
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 resize-none"
                              placeholder="Tuliskan resep obat yang diberikan...">{{ old('pemberian_obat') }}</textarea>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokter Pemeriksa</label>
                <div class="relative">
                    <select name="dokter_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                        <option value="" disabled selected>Pilih Dokter</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter->id }}" 
                                    data-start="{{ $dokter->jadwal_mulai }}" 
                                    data-end="{{ $dokter->jadwal_selesai }}"
                                    {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                {{ $dokter->nama_dokter }} — Poli {{ $dokter->spesialisasi }} ({{ $dokter->jadwal_formatted }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokumen Resep / Surat Sakit</label>
                <div class="mt-1 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100/50 transition duration-150 p-4 text-center">
                    <input type="file"
                           name="dokumen"
                           id="dokumen"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-2">Menerima format PDF, JPG, JPEG, atau PNG (Maks. 2MB)</p>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] rounded-xl shadow-lg shadow-emerald-600/10 transition-all duration-200">
                    Simpan Riwayat Kunjungan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.querySelector('input[name="tanggal_kunjungan"]');
    const dokterSelect = document.querySelector('select[name="dokter_id"]');
    
    if (dateInput && dokterSelect) {
        function filterDokters() {
            const selectedDateVal = dateInput.value;
            if (!selectedDateVal) return;
            
            const selectedDate = new Date(selectedDateVal);
            selectedDate.setHours(0,0,0,0);
            
            let hasValidSelected = false;
            
            Array.from(dokterSelect.options).forEach(option => {
                if (option.value === "") return;
                
                const startVal = option.getAttribute('data-start');
                const endVal = option.getAttribute('data-end');
                
                if (startVal && endVal) {
                    const startDate = new Date(startVal);
                    startDate.setHours(0,0,0,0);
                    const endDate = new Date(endVal);
                    endDate.setHours(23,59,59,999);
                    
                    if (selectedDate >= startDate && selectedDate <= endDate) {
                        option.disabled = false;
                        option.style.display = 'block';
                        if (option.value === dokterSelect.value) {
                            hasValidSelected = true;
                        }
                    } else {
                        option.disabled = true;
                        option.style.display = 'none';
                        if (option.selected) {
                            option.selected = false;
                        }
                    }
                }
            });
            
            if (!hasValidSelected) {
                dokterSelect.value = "";
            }
        }
        
        dateInput.addEventListener('change', filterDokters);
        filterDokters();
    }
});
</script>
@endpush
@endsection