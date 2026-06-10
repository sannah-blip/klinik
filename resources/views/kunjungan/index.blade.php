@extends('layout.index')

@section('content')

@php
    $isAdmin = auth()->check() && auth()->user()->role === 'Admin';
@endphp

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Kunjungan Pasien</h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola manajemen data riwayat kunjungan pasien klinik kampus.
            </p>
        </div>

        @if($isAdmin)
        <div>
            <a href="{{ route('kunjunganpasien.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl">
                Tambah Data Pasien
            </a>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Nama Pasien</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Dokter Bertugas</th>
                        <th class="px-6 py-4">Spesialisasi</th>
                        <th class="px-6 py-4">Dokumen</th>

                        @if($isAdmin)
                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                        @endif
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)

                    <tr class="border-b">

                        <td class="px-6 py-4 text-center">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->nama_pasien }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->status }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->dokter->nama_dokter ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->dokter->spesialisasi ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($item->dokumen)
                                <a href="{{ asset('storage/'.$item->dokumen) }}"
                                    target="_blank"
                                    class="inline-flex px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Lihat File
                                </a>
                                
                            @else
                                -
                            @endif
                        </td>

                        @if($isAdmin)
                        <td class="px-6 py-4 text-center">

                            <a href="{{ route('kunjunganpasien.edit', $item->id) }}"
                               class="text-amber-600">
                                Edit
                            </a>

                            <form action="{{ route('kunjunganpasien.destroy', $item->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600">
                                    Hapus
                                </button>

                            </form>

                        </td>
                        @endif

                    </tr>

                    @empty

                    <tr>
                        <td colspan="{{ $isAdmin ? 7 : 6 }}"
                            class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data kunjungan pasien ditemukan.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if(method_exists($data, 'hasPages') && $data->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $data->links() }}
        </div>
        @endif

    </div>

</div>

@endsection