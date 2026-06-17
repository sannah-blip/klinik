@extends('layouts.app')

@section('header_title', auth()->user()->role === 'Admin' ? 'Dashboard Admin' : 'Pendaftaran Kunjungan')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="space-y-8">
    
    @if (session('success'))
        <div id="flash-notification" class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-3 shadow-sm transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="p-1 bg-emerald-500 text-white rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('flash-notification').remove()" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg transition">
                ✕
            </button>
        </div>
    @endif

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-emerald-900/10 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -right-20 -bottom-20 w-60 h-60 bg-emerald-500/20 rounded-full blur-xl"></div>
        
        <div class="relative z-10 max-w-3xl">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Selamat Datang Kembali, {{ auth()->user()->name }}!
            </h1>
            <p class="text-emerald-100 text-sm md:text-base mt-2 leading-relaxed">
                {{ $clinicInfo->deskripsi }}
            </p>
        </div>
    </div>

    @if(auth()->user()->role === 'Admin')
        {{-- ==================== ADMIN VIEW ==================== --}}
        
        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Antrean Hari Ini</span>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $antreanHariIni }}</h3>
                </div>
                <div class="text-xs text-slate-400 mt-4">
                    Kunjungan tanggal {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pasien</span>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalPasien }}</h3>
                </div>
                <div class="text-xs text-slate-500 mt-4">
                    Semua kunjungan tercatat
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kategori</span>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-2">{{ $klusterKategori->count() }}</h3>
                </div>
                <div class="text-xs text-emerald-600 font-semibold mt-4">
                    ● <span class="text-slate-500 font-normal">Jenis layanan aktif</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[140px]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kategori Terbanyak</span>
                    <h3 class="text-xl font-extrabold text-emerald-600 mt-2 leading-tight">
                        {{ $klusterKategori->sortByDesc('total')->first()['nama'] ?? '-' }}
                    </h3>
                </div>
                <div class="text-xs text-slate-400 mt-4">
                    {{ $klusterKategori->sortByDesc('total')->first()['total'] ?? 0 }} kunjungan
                </div>
            </div>

        </div>

        {{-- Pie Chart + Quick Access --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Pie Chart Kluster Kategori --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Kluster Kunjungan per Kategori</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Distribusi kunjungan berdasarkan jenis layanan</p>
                    </div>
                    <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full border border-emerald-100">
                        {{ $totalPasien }} Total
                    </span>
                </div>

                @if($klusterKategori->count() > 0)
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        {{-- Chart Canvas --}}
                        <div class="relative w-full md:w-64 flex-shrink-0" style="height: 280px;">
                            <canvas id="kategoriPieChart"></canvas>
                        </div>

                        {{-- Legend --}}
                        <div class="flex-1 w-full space-y-3">
                            @php
                                $chartColors = [
                                    '#10b981', '#3b82f6', '#f59e0b', '#ef4444',
                                    '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
                                    '#6366f1', '#84cc16',
                                ];
                            @endphp
                            @foreach($klusterKategori->sortByDesc('total') as $idx => $item)
                            @php
                                $pct = $totalPasien > 0 ? round(($item['total'] / $totalPasien) * 100, 1) : 0;
                                $color = $chartColors[$idx % count($chartColors)];
                            @endphp
                            <div class="flex items-center gap-3 group">
                                <div class="w-3 h-3 rounded-full flex-shrink-0 shadow-sm" style="background-color: {{ $color }}"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item['nama'] }}</span>
                                        <span class="text-xs font-bold text-slate-900 ml-2 flex-shrink-0">{{ $item['total'] }} <span class="text-slate-400 font-normal">({{ $pct }}%)</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full transition-all duration-700 ease-out"
                                             style="width: {{ $pct }}%; background-color: {{ $color }}"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-3xl">📊</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Belum ada data kunjungan</p>
                        <p class="text-xs text-slate-400 mt-1">Belum ada kunjungan pasien terdaftar.</p>
                    </div>
                @endif
            </div>

            {{-- Right Column (Quick Access + Info Klinik) --}}
            <div class="flex flex-col gap-6">
                {{-- Quick Access --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex-1">
                    <h3 class="text-base font-bold text-slate-900 mb-4">Akses Cepat Administrasi</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('kunjunganpasien.index') }}" class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-emerald-500/30 hover:bg-emerald-50/20 transition group flex flex-col justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Riwayat Kunjungan</h4>
                                <p class="text-xs text-slate-400 mt-1">Pantau rekam medis dan kelola data riwayat kunjungan pasien.</p>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 mt-4 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Buka Tabel Kunjungan →
                            </span>
                        </a>

                        <a href="{{ route('dokter.index') }}" class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-emerald-500/30 hover:bg-emerald-50/20 transition group flex flex-col justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Kelola Dokter Spesialis</h4>
                                <p class="text-xs text-slate-400 mt-1">Kelola data spesialisasi dan jadwal tugas dokter jaga.</p>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 mt-4 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Buka Kelola Dokter →
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Info Klinik Card --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-slate-900">Informasi {{ $clinicInfo->nama_klinik }}</h3>
                        <a href="{{ route('clinic-info.edit') }}" class="text-xs font-bold text-emerald-600 hover:underline">Edit</a>
                    </div>
                    
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Jam Operasional</span>
                            <span class="font-semibold text-slate-700">{{ $clinicInfo->jam_operasional }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Kontak Darurat</span>
                            <span class="font-semibold text-slate-700">{{ $clinicInfo->kontak_darurat }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-3 text-[11px] text-slate-500 text-center mt-4">
                        Sistem aman terenkripsi berbasis peran pengguna.
                    </div>
                </div>
            </div>

        </div>

    @else
        {{-- ==================== USER VIEW ==================== --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 space-y-6">
                {{-- Form Pendaftaran Kunjungan --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="pb-4 mb-6 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-900">Formulir Pendaftaran Kunjungan</h3>
                        <p class="text-xs text-slate-400 mt-1">Silakan isi keluhan dan pilih dokter spesialis untuk antrean Anda.</p>
                    </div>

                    <form action="{{ route('kunjunganpasien.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Pasien</label>
                            <input type="text"
                                   name="nama_pasien"
                                   value="{{ old('nama_pasien', auth()->user()->name) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200"
                                   placeholder="Nama Lengkap Pasien" required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Anda</label>
                                <div class="relative">
                                    <select name="status"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
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
                                       value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}"
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Layanan</label>
                                <div class="relative">
                                    <select name="kategori_kunjungan_id"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                                        @foreach($kategori as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_kunjungan_id') == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
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
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Dokter</label>
                                <div class="relative">
                                    <select name="dokter_id"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 appearance-none cursor-pointer" required>
                                        @foreach($dokters as $dokter)
                                            <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                                {{ $dokter->nama_dokter }} (Poli {{ $dokter->spesialisasi }})
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
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keluhan Utama</label>
                            <textarea name="keluhan_utama"
                                      rows="4"
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-sm rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50 transition-all duration-200 resize-none"
                                      placeholder="Jelaskan keluhan medis Anda..." required>{{ old('keluhan_utama') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dokumen Pendukung (Opsional)</label>
                            <div class="mt-1 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100/50 transition duration-150 p-4 text-center">
                                <input type="file"
                                       name="dokumen"
                                       id="dokumen"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-2">File dokumen pendukung (PDF, JPG, JPEG, PNG, Maks. 2MB)</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] rounded-xl shadow-lg shadow-emerald-600/10 transition-all duration-200">
                                Kirim Pendaftaran Kunjungan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Status & Riwayat Pendaftaran Kunjungan --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="pb-4 mb-6 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-900">Status & Nomor Antrean Anda</h3>
                        <p class="text-xs text-slate-400 mt-1">Daftar kunjungan yang didaftarkan beserta nomor antrean Anda.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <th class="px-4 py-3">Tgl Kunjungan</th>
                                    <th class="px-4 py-3 text-center">No. Antrean</th>
                                    <th class="px-4 py-3">Poli / Dokter</th>
                                    <th class="px-4 py-3">Keluhan</th>
                                    <th class="px-4 py-3">Status / Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($myVisits as $visit)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-4 py-3.5 font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($visit->tanggal_kunjungan)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-extrabold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-xl">
                                            #{{ $visit->no_antrean }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-slate-800">{{ $visit->dokter->nama_dokter ?? '-' }}</div>
                                        <div class="text-xs text-slate-400 font-semibold">Poli {{ $visit->dokter->spesialisasi ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-500 max-w-[200px] truncate" title="{{ $visit->keluhan_utama }}">
                                        {{ $visit->keluhan_utama }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @if($visit->tindakan_obat === 'Menunggu Pemeriksaan')
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-lg">
                                                Menunggu Pemeriksaan
                                            </span>
                                        @else
                                            <div class="font-bold text-emerald-700">Tercatat</div>
                                            <div class="text-xs text-slate-500 max-w-[150px] truncate" title="{{ $visit->tindakan_obat }}">{{ $visit->tindakan_obat }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada pendaftaran kunjungan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column (Informasi Klinik & Jadwal Dokter) --}}
            <div class="space-y-6">
                
                {{-- Info Klinik Card --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-3">Informasi {{ $clinicInfo->nama_klinik }}</h3>
                    
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Jam Operasional</span>
                            <span class="font-semibold text-slate-700">{{ $clinicInfo->jam_operasional }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs border-b border-slate-50 pb-2">
                            <span class="text-slate-500">Kontak Darurat</span>
                            <span class="font-semibold text-slate-700">{{ $clinicInfo->kontak_darurat }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-3 text-[11px] text-slate-500 text-center mt-4">
                        Hubungi kontak darurat di atas jika memerlukan penanganan segera.
                    </div>
                </div>

                {{-- Jadwal Dokter Spesialis Card --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-3">Jadwal Dokter Spesialis</h3>
                    <div class="space-y-3.5 mt-4">
                        @forelse($dokters as $dokter)
                        <div class="border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">{{ $dokter->nama_dokter }}</span>
                                <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                    Poli {{ $dokter->spesialisasi }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                                📅 {{ $dokter->jadwal_jaga }}
                            </p>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-2">Belum ada jadwal dokter tersedia.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    @endif

</div>

@if(auth()->user()->role === 'Admin')
{{-- Chart.js Script (Only for Admin) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('kategoriPieChart');
    if (!canvas) return;

    const rawData = @json($klusterKategori->values());

    if (!rawData || rawData.length === 0) return;

    const labels = rawData.map(d => d.nama);
    const values = rawData.map(d => d.total);

    const palette = [
        '#10b981', '#3b82f6', '#f59e0b', '#ef4444',
        '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
        '#6366f1', '#84cc16',
    ];

    const colors = labels.map((_, i) => palette[i % palette.length]);

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 900,
                easing: 'easeInOutQuart',
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#f8fafc',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = ((ctx.parsed / total) * 100).toFixed(1);
                            return ` ${ctx.parsed} kunjungan (${pct}%)`;
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height, ctx } = chart;
                ctx.restore();
                const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                ctx.font = 'bold 26px Plus Jakarta Sans, sans-serif';
                ctx.fillStyle = '#0f172a';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(total, width / 2, height / 2 - 10);
                ctx.font = '12px Plus Jakarta Sans, sans-serif';
                ctx.fillStyle = '#94a3b8';
                ctx.fillText('Total', width / 2, height / 2 + 16);
                ctx.save();
            }
        }]
    });
});
</script>
@endif
@endsection