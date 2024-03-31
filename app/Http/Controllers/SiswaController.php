<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\RekapPas;
use App\Models\RekapPts;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function listSiswa(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $listSiswa = Siswa::with('jurusan')->paginate(10);
        } else {
            $listSiswa = Siswa::where('namaSiswa', 'like', "%$search%")->with('jurusan')->paginate(10)->withQueryString();
        }
        return view('Siswa/siswa', ['listSiswa' => $listSiswa]);
    }

    public function addSiswaView()
    {
        $jurusan = Jurusan::get();
        return view('Siswa/tambahSiswa', ['jurusan' => $jurusan]);
    }

    public function handleAddsiswa(Request $request)
    {
        $validate = $request->validate([
            'namaSiswa' => 'required|string|max:255',
            'nis' => 'required|string|max:40|unique:siswa,nis',
            'nisn' => 'required|string|max:40|unique:siswa,nisn',
            'idJurusan' => 'required|string|exists:jurusan',
            'tahunMasuk' => 'required|integer|min:1920|max:' . date('Y'),
            'namaWali' => 'required|string|max:255',
            'nikWali' => 'required|string|max:40',
            'alamat' => 'required|string',
            'hubunganKeluarga' => 'required|in:Ayah,Ibu,Kakak,Paman,Ayah,',
        ]);

        $siswa = Siswa::create($validate);

        if ($siswa) {
            return redirect('dashboard/siswa')->with('success', 'Siswa Baru Berhasil Ditambahkan');
        }
        return redirect()->refresh()->withInput()->withErrors('error', 'Siswa Baru Gagal Ditambahkan');
    }

    public function detailSiswa($idSiswa)
    {
        $siswa = Siswa::where('idSiswa', $idSiswa)->with('jurusan')->first();
        $kelas = RekapPts::where('siswa', $idSiswa)
            ->select('kelas.namaKelas', 'kelas.waliKelas', 'kelas.tahunAjaran', 'kelas.semester')
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'rekap_pts.kelas')
            ->groupBy('kelas.namaKelas', 'kelas.waliKelas', 'kelas.tahunAjaran', 'kelas.semester')
            ->get();

        // return response()->json($kelas);
        return view('Siswa/detailSiswa', ['siswa' => $siswa, 'kelas' => $kelas]);
    }

    public function editSiswaView($idSiswa)
    {
        $jurusan = Jurusan::get();
        $siswa = Siswa::where('idSiswa', $idSiswa)->first();
        if (!$siswa) {
            return abort(404);
        }
        return view('Siswa/editSiswa', ['jurusan' => $jurusan, 'siswa' => $siswa]);
    }


    public function handleEditSiswa($idSiswa, Request $request)
    {
        $validate = $request->validate([
            'namaSiswa' => 'required|string|max:255',
            'nis' => 'required|string|max:40|unique:siswa,nis,' . $idSiswa . ',idSiswa',
            'nisn' => 'required|string|max:40|unique:siswa,nisn,' . $idSiswa . ',idSiswa',
            'idJurusan' => 'required|string|exists:jurusan',
            'tahunMasuk' => 'required|integer|min:1920|max:' . date('Y'),
            'namaWali' => 'required|string|max:255',
            'nikWali' => 'required|string|max:40',
            'alamat' => 'required|string',
            'hubunganKeluarga' => 'required|in:Ayah,Ibu,Kakak,Paman,Ayah,',
        ]);

        $siswa = Siswa::where('idSiswa', $idSiswa)->update($validate);

        if ($siswa) {
            return redirect()->route('detailSiswa', ['idSiswa' => $idSiswa])->with('success', 'Data Siswa Berhasil Diperbarui');
        }
        return redirect()->refresh()->withInput()->withErrors('error', 'Data Siswa Gagal Diperbarui');
    }
}
