@extends('layout.index')

@section('content')

<div class="d-flex justify-content-between mb-4">

    <h3>Data Kunjungan Pasien</h3>

    <a href="{{ route('kunjungan.create') }}"
        class="btn btn-primary">

    Tambah Data

    </a>

</div>

<form action="{{ route('kunjungan.index') }}"
        method="GET"
        class="mb-3">

    <input type="text"
            name="search"
            class="form-control"
            placeholder="Cari pasien...">

</form>

{{-- (Optional) Statistik dari controller --}}
{{-- Jika tidak dipakai, tidak akan error. --}}
<div class="mb-3">
    <small class="text-muted">
        Total Pasien: {{ $totalPasien ?? '-' }} |
        Mahasiswa: {{ $totalMahasiswa ?? '-' }} |
        Staf: {{ $totalStaf ?? '-' }} |
        Umum: {{ $totalUmum ?? '-' }}
    </small>
</div>

<table class="table table-bordered">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Status</th>
    <th>Dokter</th>
    <th>Aksi</th>
</tr>

@foreach($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->nama_pasien }}</td>

<td>{{ $item->status }}</td>

<td>{{ $item->nama_dokter }}</td>

<td>

<a href="{{ route('kunjungan.edit', $item->id) }}"
    class="btn btn-warning btn-sm">

    Edit

</a>

<form action="{{ route('kunjungan.destroy', $item->id) }}"
        method="POST"
        class="d-inline">

    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm">

        Hapus

    </button>

</form>

</td>

</tr>

@endforeach

</table>

{{ $data->links() }}

@endsection