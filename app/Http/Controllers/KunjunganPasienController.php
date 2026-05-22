<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KunjunganPasien;

class KunjunganPasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = KunjunganPasien::where(
            'nama_pasien',
            'like',
            "%$search%"
        )
        ->latest()
        ->paginate(5);

        $totalPasien = KunjunganPasien::count();

        $totalMahasiswa = KunjunganPasien::where(
            'status',
            'Mahasiswa'
        )->count();

        $totalStaf = KunjunganPasien::where(
            'status',
            'Staf'
        )->count();

        $totalUmum = KunjunganPasien::where(
            'status',
            'Umum'
        )->count();

        return view(
            'kunjungan.index',
            compact(
                'data',
                'totalPasien',
                'totalMahasiswa',
                'totalStaf',
                'totalUmum'
            )
        );
    }

    public function create()
    {
        return view('kunjungan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'status' => 'required|in:Mahasiswa,Staf,Umum',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_utama' => 'required',
            'tindakan_obat' => 'required',
            'nama_dokter' => 'required',
        ]);

        KunjunganPasien::create($request->only([
            'nama_pasien',
            'status',
            'tanggal_kunjungan',
            'keluhan_utama',
            'tindakan_obat',
            'nama_dokter',
        ]));

        return redirect('/kunjungan')
        ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = KunjunganPasien::findOrFail($id);

        return view('kunjungan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = KunjunganPasien::findOrFail($id);

        $request->validate([
            'nama_pasien' => 'required',
            'status' => 'required|in:Mahasiswa,Staf,Umum',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_utama' => 'required',
            'tindakan_obat' => 'required',
            'nama_dokter' => 'required',
        ]);

        $data->update($request->only([
            'nama_pasien',
            'status',
            'tanggal_kunjungan',
            'keluhan_utama',
            'tindakan_obat',
            'nama_dokter',
        ]));

        return redirect('/kunjungan')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = KunjunganPasien::findOrFail($id);

        $data->delete();

        return redirect('/kunjungan')
        ->with('success', 'Data berhasil dihapus');
    }
}