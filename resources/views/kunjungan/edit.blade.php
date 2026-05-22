@extends('layout.index')

@section('content')

<h3>Edit Data Pasien</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('kunjungan.update', $data->id) }}" method="POST">

    @csrf
    @method('PUT')

    <input type="text"
           name="nama_pasien"
           class="form-control mb-3"
           value="{{ old('nama_pasien', $data->nama_pasien) }}">

    <select name="status"
            class="form-control mb-3">

        <option value="Mahasiswa" {{ old('status', $data->status) == 'Mahasiswa' ? 'selected' : '' }}>
        Mahasiswa
        </option>

        <option value="Staf" {{ old('status', $data->status) == 'Staf' ? 'selected' : '' }}>
        Staf
        </option>

        <option value="Umum" {{ old('status', $data->status) == 'Umum' ? 'selected' : '' }}>
        Umum
        </option>

    </select>

    <input type="date"
           name="tanggal_kunjungan"
           class="form-control mb-3"
           value="{{ $data->tanggal_kunjungan }}">

    <textarea name="keluhan_utama"
              class="form-control mb-3">{{ $data->keluhan_utama }}</textarea>

    <textarea name="tindakan_obat"
              class="form-control mb-3">{{ $data->tindakan_obat }}</textarea>

    <input type="text"
           name="nama_dokter"
           class="form-control mb-3"
           value="{{ $data->nama_dokter }}">

    <button class="btn btn-warning">
        Update
    </button>

</form>

@endsection