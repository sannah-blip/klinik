@extends('layouts.app')

@section('header_title', 'Dashboard Utama')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="space-y-8">
    
    {{-- Hero Banner --}}
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
                    <p class="text-xs text-slate-400 mt-1">Mulai tambahkan kunjungan pasien untuk melihat statistik</p>
                    @if(auth()->user()->role === 'Admin')
                    <a href="{{ route('kunjunganpasien.create') }}" class="mt-4 text-xs font-semibold text-emerald-600 hover:underline">+ Tambah Kunjungan</a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="flex flex-col gap-6">
            {{-- Quick Access --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex-1">
                <h3 class="text-base font-bold text-slate-900 mb-4">Akses Cepat Layanan</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    
                    @if(auth()->user()->role === 'Admin')
                    <a href="{{ route('kunjunganpasien.create') }}" class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-emerald-500/30 hover:bg-emerald-50/20 transition group flex flex-col justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Daftarkan Kunjungan Baru</h4>
                            <p class="text-xs text-slate-400 mt-1">Input data pasien baru yang datang berobat ke klinik.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 mt-4 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Buka Form →
                        </span>
                    </a>
                    @endif

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

            {{-- Info Klinik --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm">
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

                <div class="bg-slate-50 rounded-xl p-3 text-[11px] text-slate-500 text-center mt-4">
                    Sistem aman terenkripsi berbasis peran pengguna.
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Chart.js Script --}}
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
@endsection