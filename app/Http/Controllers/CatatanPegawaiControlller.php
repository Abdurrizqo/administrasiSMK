<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CatatanPegawai;
use Illuminate\Http\Request;

class CatatanPegawaiControlller extends Controller
{
    public function createCatatanPegawai($idPegawai, Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|string|in:CAPAIAN,PELANGGARAN',
            'keterangan' => 'required|string|',
        ], [
            'required' => 'Form Harus Di Isi',
            'kategori.in' => 'Nilai Form Tidak Valid',
        ]);
        try {
            CatatanPegawai::create(
                [
                    'kategori' => $validate['kategori'],
                    'keterangan' => $validate['keterangan'],
                    'idPegawai' => $idPegawai,
                ]
            );
            return redirect()->refresh()->withInput()->with('success', 'Catatan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->refresh()->with('error', "Catatan Gagal Ditambahkan, $mesg");
        }
    }

    public function deleteCatatanPegawai($idCatatanPegawai)
    {
        $catatanPegawai = CatatanPegawai::where('idCatatanPegawai', $idCatatanPegawai)->delete();
        if ($catatanPegawai) {
            return redirect()->back()->with('success', 'Catatan Pegawai Berhasil Dihapus');
        }
        return redirect()->back()->with('error', 'Catatan Pegawai Gagal Dihapus');
    }
}
