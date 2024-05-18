<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SertifikatPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatPegawaiControlller extends Controller
{
    public function addSertifikatPegawai($idPegawai, Request $request)
    {
        $validate = $request->validate([
            'sertifikat' => 'required|file|mimes:pdf|max:3072',
            'judul' => 'required|string|max:250',
        ], [
            'required' => 'Form Harus Di Isi',
            'judul.max' => 'Nilai Terlalu Panjang',
            'sertifikat.max' => 'Maksimum ukuran berkas adalah 3MB',
        ]);

        try {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('sertifikat')->getClientOriginalExtension();
            $validate['sertifikat'] = $request->file('sertifikat')->storeAs('sertifikatPegawai', $fileName, 'public');

            SertifikatPegawai::create(
                [
                    'sertifikat' => $validate['sertifikat'],
                    'judul' => $validate['judul'],
                    'idPegawai' => $idPegawai,
                ]
            );
            return redirect()->back()->with('success', 'Sertifikat Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Sertifikat Gagal Ditambahkan, $mesg");
        }
    }

    public function deleteSertifikatPegawai($idSertifikatPegawai)
    {
        $sertifikat = SertifikatPegawai::where('idSertifikatGuru', $idSertifikatPegawai)->first();

        if (isset($sertifikat->sertifikat)) {
            Storage::delete("public/{$sertifikat->sertifikat}");
        }

        $sertifikat->delete();
        if ($sertifikat) {
            return redirect()->back()->with('success', 'Sertifikat Pegawai Berhasil Dihapus');
        }
        return redirect()->back()->with('error', 'Sertifikat Pegawai Gagal Dihapus');
    }
}
