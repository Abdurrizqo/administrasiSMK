<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CatatanSiswa;
use Illuminate\Http\Request;

class CatatanSiswaController extends Controller
{
    public function createCatatanSiswa($idSiswa, Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|string|in:CAPAIAN,PELANGGARAN',
            'keterangan' => 'required|string|',
        ], [
            'required' => 'Form Harus Di Isi',
            'kategori.in' => 'Nilai Form Tidak Valid',
        ]);
        try {
            CatatanSiswa::create(
                [
                    'kategori' => $validate['kategori'],
                    'keterangan' => $validate['keterangan'],
                    'idSiswa' => $idSiswa,
                ]
            );
            return redirect()->refresh()->withInput()->with('success', 'Catatan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->refresh()->with('error', "Catatan Gagal Ditambahkan, $mesg");
        }
    }

    public function createCatatanSiswaByGuru($idSiswa, Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|string|in:CAPAIAN,PELANGGARAN',
            'keterangan' => 'required|string|',
        ], [
            'required' => 'Form Harus Di Isi',
            'kategori.in' => 'Nilai Form Tidak Valid',
        ]);
        try {
            CatatanSiswa::create(
                [
                    'kategori' => $validate['kategori'],
                    'keterangan' => $validate['keterangan'],
                    'idSiswa' => $idSiswa,
                ]
            );
            return redirect()->back()->withInput()->with('successAdd', 'Catatan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('errorAdd', "Catatan Gagal Ditambahkan, $mesg");
        }
    }

    public function deleteCatatanSiswa($idCatatanSiswa)
    {
        $catatanSiswa = CatatanSiswa::where('idCatatanSiswa', $idCatatanSiswa)->delete();
        if ($catatanSiswa) {
            return redirect()->back()->with('successAdd', 'Catatan Siswa Berhasil Dihapus');
        }
        return redirect()->back()->with('errorAdd', 'Catatan Siswa Gagal Dihapus');
    }
}
