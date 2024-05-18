<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SertifikatSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatSiswaControlller extends Controller
{
    public function addSertifikatSiswa($idSiswa, Request $request)
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
            $validate['sertifikat'] = $request->file('sertifikat')->storeAs('sertifikatSiswa', $fileName, 'public');

            SertifikatSiswa::create(
                [
                    'sertifikat' => $validate['sertifikat'],
                    'judul' => $validate['judul'],
                    'idSiswa' => $idSiswa,
                ]
            );
            return redirect()->back()->with('successAdd', 'Sertifikat Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('errorAdd', "Sertifikat Gagal Ditambahkan, $mesg");
        }
    }

    public function deleteSertifikatSiswa($idSertifikatSiswa)
    {
        $sertifikat = SertifikatSiswa::where('idSertifikatSiswa', $idSertifikatSiswa)->first();

        if (isset($sertifikat->sertifikat)) {
            Storage::delete("public/{$sertifikat->sertifikat}");
        }

        $sertifikat->delete();
        if ($sertifikat) {
            return redirect()->back()->with('successAdd', 'Sertifikat Siswa Berhasil Dihapus');
        }
        return redirect()->back()->with('errorAdd', 'Sertifikat Siswa Gagal Dihapus');
    }
}
