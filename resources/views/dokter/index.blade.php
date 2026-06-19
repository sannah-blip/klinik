@extends('layouts.app')

@section('header_title', 'Kelola Dokter Spesialis')

@section('content')
<div class="space-y-6">

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

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Dokter Spesialis</h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola dokter dan jadwal jaga mereka di klinik kampus.
            </p>
        </div>

        <div>
            <a href="{{ route('dokter.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] rounded-xl shadow-lg shadow-emerald-600/10 transition-all duration-200">
                + Tambah Dokter
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Nama Dokter</th>
                        <th class="px-6 py-4">Spesialisasi</th>
                        <th class="px-6 py-4">Jadwal Jaga</th>
                        <th class="px-6 py-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($dokters as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        
                        <td class="px-6 py-4 text-center font-medium text-slate-400">
                            {{ ($dokters->currentPage() - 1) * $dokters->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-900">
                            {{ $item->nama_dokter }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-lg">
                                Poli {{ $item->spesialisasi }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-500 font-medium">
                            {{ $item->jadwal_formatted }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('dokter.edit', $item->id) }}"
                                   class="text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline transition">
                                    Edit
                                </a>

                                <span class="text-slate-200">|</span>

                                <form action="{{ route('dokter.destroy', $item->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dokter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5"
                            class="px-6 py-16 text-center text-slate-400 bg-slate-50/30">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-2xl mb-2">🩺</span>
                                <p class="text-sm font-medium">Belum ada data dokter terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        @if(method_exists($dokters, 'hasPages') && $dokters->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $dokters->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
