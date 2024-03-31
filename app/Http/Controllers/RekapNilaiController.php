<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\RekapPas;
use App\Models\RekapPts;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    public function inputPTS($idKelasMapel, $idKelas)
    {
        $kelas = Kelas::where('idKelas', $idKelas)->with('wali')->first();
        $listSiswa = RekapPts::where('kelasMapel', $idKelasMapel)
            ->where('kelas', $idKelas)
            ->with('dataSiswa')
            ->paginate(5);

        return view('pegawai/inputPTS', ['listSiswa' => $listSiswa, 'kelas' => $kelas]);
    }

    public function handleInputRekapPTS($idRekapPts, Request $request)
    {
        $validate = $request->validate([
            'nilaiAkademik' => ['required', 'numeric', 'between:1,100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'terbilangNilaiAkademik' => 'required|string|min:1',
            'nilaiKeterampilan' => ['required', 'numeric', 'between:1,100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'terbilangNilaiKeterampilan' => 'required|string|min:1',
            'keterangan' => 'required|string|min:1',
        ]);
        try {
            $rekapNilaiPTS = RekapPts::where('idRekapPts', $idRekapPts)->update($validate);
            return response()->json($rekapNilaiPTS);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function inputPAS($idKelasMapel, $idKelas)
    {
        $kelas = Kelas::where('idKelas', $idKelas)->with('wali')->first();
        $listSiswa = RekapPas::where('kelasMapel', $idKelasMapel)
            ->where('kelas', $idKelas)
            ->with('dataSiswa')
            ->paginate(5);

        return view('pegawai/inputPAS', ['listSiswa' => $listSiswa, 'kelas' => $kelas]);
    }

    public function handleInputRekapPAS($idRekapPas, Request $request)
    {
        $validate = $request->validate([
            'nilaiAkademik' => ['required', 'numeric', 'between:1,100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'terbilangNilaiAkademik' => 'required|string|min:1',
            'nilaiKeterampilan' => ['required', 'numeric', 'between:1,100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'terbilangNilaiKeterampilan' => 'required|string|min:1',
            'keterangan' => 'required|string|min:1',
            'status' => 'required|string|in:NAIK KELAS, TINGGAL KELAS',
        ]);

        try {
            $rekapNilaiPAS = RekapPas::where('idRekapPas', $idRekapPas)->update($validate);
            return response()->json($rekapNilaiPAS);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
