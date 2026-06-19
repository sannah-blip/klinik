@extends('layouts.app')

@section('header_title', 'Data Kunjungan Pasien')

@section('content')

@php
    $isAdmin = auth()->check() && auth()->user()->role === 'Admin';
@endphp

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Kunjungan Pasien</h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola manajemen data riwayat kunjungan pasien klinik kampus.
            </p>
        </div>
        @if($isAdmin)
        <div>
            <a href="{{ route('kunjunganpasien.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] rounded-xl shadow-lg shadow-emerald-600/10 transition-all duration-200">
                + Tambah Kunjungan
            </a>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Nama Pasien</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Dokter Bertugas</th>
                        <th class="px-6 py-4">Spesialisasi</th>
                        <th class="px-6 py-4">Dokumen</th>
                        @if($isAdmin)
                        <th class="px-6 py-4 text-center w-40">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        
                        <td class="px-6 py-4 text-center font-medium text-slate-400">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-900">
                            {{ $item->nama_pasien }}
                        </td>

                        <td class="px-6 py-4">
                            @if(Str::lower($item->status) === 'selesai')
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-lg">
                                    {{ $item->status }}
                                </span>
                            @elseif(Str::lower($item->status) === 'antre' || Str::lower($item->status) === 'proses')
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-lg">
                                    {{ $item->status }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-slate-600 bg-slate-100 rounded-lg">
                                    {{ $item->status }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 rounded-lg font-medium">
                                {{ $item->kategoriKunjungan->nama_kategori ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $item->dokter->nama_dokter ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->dokter->spesialisasi ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($item->dokumen)
                                <a href="{{ asset('storage/'.$item->dokumen) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">
                                    Lihat File
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>

                        @if($isAdmin)
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('kunjunganpasien.edit', $item->id) }}"
                                   class="text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline transition">
                                    Edit
                                </a>

                                <span class="text-slate-200">|</span>

                                <form action="{{ route('kunjunganpasien.destroy', $item->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif

                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 8 : 7 }}"
                            class="px-6 py-16 text-center text-slate-400 bg-slate-50/30">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-2xl mb-2">📂</span>
                                <p class="text-sm font-medium">Tidak ada data kunjungan pasien ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        @if(method_exists($data, 'hasPages') && $data->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $data->links() }}
        </div>
        @endif

    </div>
</div>
@endsection