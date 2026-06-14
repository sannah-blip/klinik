<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KunjunganPasien;
use App\Models\KategoriKunjungan;
use App\Models\Dokter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KunjunganPasienController extends Controller
{
    public function dashboard()
    {
        $totalPasien = KunjunganPasien::count();
        $antreanHariIni = KunjunganPasien::whereDate('tanggal_kunjungan', today())->count();
        $selesaiHariIni = KunjunganPasien::whereDate('tanggal_kunjungan', today())->count();

        // Data kluster berdasarkan kategori untuk pie chart
        $klusterKategori = KunjunganPasien::select(
            'kategori_kunjungan_id',
            DB::raw('count(*) as total')
        )
        ->with('kategoriKunjungan')
        ->groupBy('kategori_kunjungan_id')
        ->get()
        ->map(function ($item) {
            return [
                'nama' => $item->kategoriKunjungan ? $item->kategoriKunjungan->nama_kategori : 'Tidak Diketahui',
                'total' => $item->total,
            ];
        });

        return view('dashboard', compact(
            'totalPasien',
            'antreanHariIni',
            'klusterKategori'
        ));
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $data = KunjunganPasien::with('kategoriKunjungan', 'dokter')
        ->where(    
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
        $kategori = \App\Models\KategoriKunjungan::all();
        $dokters = \App\Models\Dokter::all();
        return view('kunjungan.create', compact('kategori', 'dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'status' => 'required|in:Mahasiswa,Staf,Umum',
            'tanggal_kunjungan' => 'required|date',
            'kategori_kunjungan_id' => 'required',
            'keluhan_utama' => 'required',
            'tindakan_obat' => 'required',
            'dokter_id' => 'required',
            'dokumen' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

    $dokumenPath = null;

    if ($request->hasFile('dokumen')) {
        $dokumenPath = $request->file('dokumen')
            ->store('dokumen_pasien', 'public');
    }

    KunjunganPasien::create([
        'nama_pasien' => $request->nama_pasien,
        'status' => $request->status,
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'kategori_kunjungan_id' => $request->kategori_kunjungan_id,
        'keluhan_utama' => $request->keluhan_utama,
        'tindakan_obat' => $request->tindakan_obat,
        'dokter_id' => $request->dokter_id,
        'dokumen' => $dokumenPath,
    ]);

    return redirect('/kunjunganpasien')
        ->with('success', 'Data berhasil ditambahkan');
    }
   public function edit($id)
    {
        // Ubah dari $data menjadi $item
        $item = KunjunganPasien::findOrFail($id);
        $dokters = Dokter::all();
        $kategori = KategoriKunjungan::all();
        // Kirimkan sebagai 'item' ke view
        return view('kunjungan.edit', compact('item', 'dokters', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $item = KunjunganPasien::findOrFail($id);

        $request->validate([
            'nama_pasien' => 'required',
            'status' => 'required|in:Mahasiswa,Staf,Umum',
            'tanggal_kunjungan' => 'required|date',
            'kategori_kunjungan_id' => 'required',
            'keluhan_utama' => 'required',
            'tindakan_obat' => 'required',
            'dokter_id' => 'required',
            'dokumen' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $dokumenPath = $item->dokumen;

        if ($request->hasFile('dokumen')) {
            if ($item->dokumen && Storage::disk('public')->exists($item->dokumen)) {
                Storage::disk('public')->delete($item->dokumen);
            }

            $dokumenPath = $request->file('dokumen')
                ->store('dokumen_pasien', 'public');
        }

        $item->update([
            'nama_pasien' => $request->nama_pasien,
            'status' => $request->status,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'kategori_kunjungan_id' => $request->kategori_kunjungan_id,
            'keluhan_utama' => $request->keluhan_utama,
            'tindakan_obat' => $request->tindakan_obat,
            'dokter_id' => $request->dokter_id,
            'dokumen' => $dokumenPath,
        ]);
        return redirect('/kunjunganpasien')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = KunjunganPasien::findOrFail($id);

        if ($data->dokumen && Storage::disk('public')->exists($data->dokumen)) {
            Storage::disk('public')->delete($data->dokumen);
        }

        $data->delete();

        return redirect('/kunjunganpasien')
            ->with('success', 'Data berhasil dihapus');
    }
}