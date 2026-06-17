<?php

namespace App\Http\Controllers;

use App\Models\ClinicInfo;
use Illuminate\Http\Request;

class ClinicInfoController extends Controller
{
    public function edit()
    {
        $info = ClinicInfo::first() ?? new ClinicInfo();
        return view('clinic_info.edit', compact('info'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_klinik' => 'required|string|max:255',
            'jam_operasional' => 'required|string|max:255',
            'kontak_darurat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $info = ClinicInfo::first();
        if (!$info) {
            $info = new ClinicInfo();
        }

        $info->fill($request->only([
            'nama_klinik',
            'jam_operasional',
            'kontak_darurat',
            'deskripsi',
        ]))->save();

        return redirect()->route('dashboard')->with('success', 'Informasi klinik berhasil diperbarui.');
    }
}
