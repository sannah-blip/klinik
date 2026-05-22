@extends('layout.index')

@section('content')

<h3>Tambah Data Pasien</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('kunjungan.store') }}" method="POST">

    @csrf

    <input type="text"
           name="nama_pasien"
           value="{{ old('nama_pasien') }}"
           class="form-control mb-3"
           placeholder="Nama Pasien">

    <select name="status"
            class="form-control mb-3">

        <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        <option value="Staf" {{ old('status') == 'Staf' ? 'selected' : '' }}>Staf</option>
        <option value="Umum" {{ old('status') == 'Umum' ? 'selected' : '' }}>Umum</option>

    </select>

    <input type="date"
           name="tanggal_kunjungan"
           class="form-control mb-3">

    <textarea name="keluhan_utama"
              class="form-control mb-3"
              placeholder="Keluhan"></textarea>

    <textarea name="tindakan_obat"
              class="form-control mb-3"
              placeholder="Tindakan / Obat"></textarea>

    <input type="text"
           name="nama_dokter"
           class="form-control mb-3"
           placeholder="Nama Dokter">

    <button class="btn btn-success">
        Simpan
    </button>

</form>

@endsection