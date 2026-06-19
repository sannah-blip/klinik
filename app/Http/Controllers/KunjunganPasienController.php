<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KunjunganPasien;
use App\Models\KategoriKunjungan;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KunjunganPasienController extends Controller
{
    public function dashboard()
    {
        $clinicInfo = \App\Models\ClinicInfo::first() ?? new \App\Models\ClinicInfo([
            'nama_klinik' => 'Klinik Kampus',
            'jam_operasional' => '08:00 - 16:00',
            'kontak_darurat' => 'Ext-119',
            'deskripsi' => 'Sistem Informasi Klinik Kampus siap digunakan.'
        ]);

        if (Auth::user()->role === 'Admin') {
            $totalPasien = KunjunganPasien::count();
            $antreanHariIni = KunjunganPasien::whereDate('tanggal_kunjungan', today())->count();

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
                'klusterKategori',
                'clinicInfo'
            ));
        } else {
            $kategori = \App\Models\KategoriKunjungan::all();
            $dokters = \App\Models\Dokter::all();

            $myVisits = KunjunganPasien::where('user_id', Auth::id())
                ->with('dokter', 'kategoriKunjungan')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($visit) {
                    $visit->no_antrean = KunjunganPasien::whereDate('tanggal_kunjungan', $visit->tanggal_kunjungan)
                        ->where('dokter_id', $visit->dokter_id)
                        ->where('id', '<=', $visit->id)
                        ->count();
                    return $visit;
                });

            return view('dashboard', compact(
                'clinicInfo',
                'kategori',
                'dokters',
                'myVisits'
            ));
        }
    }

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses ditolak.');
        }

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
        if (Auth::user()->role === 'Admin') {
            abort(403, 'Admin tidak dapat menambah kunjungan langsung.');
        }

        $kategori = \App\Models\KategoriKunjungan::all();
        $dokters = \App\Models\Dokter::all();
        return view('kunjungan.create', compact('kategori', 'dokters'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'Admin') {
            abort(403, 'Admin tidak dapat menambah kunjungan langsung.');
        }

        $request->validate([
            'nama_pasien' => 'required',
            'status' => 'required|in:Mahasiswa,Staf,Umum',
            'tanggal_kunjungan' => 'required|date',
            'kategori_kunjungan_id' => 'required',
            'keluhan_utama' => 'required',
            'dokter_id' => 'required',
            'dokumen' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $dokumenPath = null;

        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')
                ->store('dokumen_pasien', 'public');
        }

        $kunjungan = KunjunganPasien::create([
            'user_id' => Auth::id(),
            'nama_pasien' => $request->nama_pasien,
            'status' => $request->status,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'kategori_kunjungan_id' => $request->kategori_kunjungan_id,
            'keluhan_utama' => $request->keluhan_utama,
            'tindakan_obat' => 'Menunggu Pemeriksaan',
            'dokter_id' => $request->dokter_id,
            'dokumen' => $dokumenPath,
        ]);

        $noAntrean = KunjunganPasien::whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
            ->where('dokter_id', $kunjungan->dokter_id)
            ->where('id', '<=', $kunjungan->id)
            ->count();

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran kunjungan Anda berhasil dikirim. Nomor Antrean Anda: #' . $noAntrean);
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