<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
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
        $jurusan = Jurusan::where('isActive', true)->get();
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

        $kelas = KelasSiswa::select(['idKelasSiswa', 'kelas_siswa.idKelas', 'namaKelas', 'tahunAjaran', 'waliKelas', 'namaPegawai', 'kelas_siswa.status', 'kelas_siswa.idSiswa'])
            ->where('idSiswa', $idSiswa)
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_siswa.idKelas')
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas.waliKelas')
            ->orderBy('tahunAjaran', 'desc')
            ->get();


        return view('Siswa/detailSiswa', ['siswa' => $siswa, 'kelas' => $kelas]);
    }

    public function detailRaportSiswa($idSiswa, $idKelas, Request $request)
    {

        $semester = $request->query('semester') === "GENAP" ? "GENAP" : "GANJIL";

        if ($semester === "GANJIL") {
            $selectAbsen = ['kelas_siswa.idSiswa', 'namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status', 'totalHadirGanjil as totalHadir', 'totalSakitGanjil as totalSakit', 'totalTanpaKeteranganGanjil as totalTanpaKeterangan', 'totalIzinGanjil as totalIzin', 'keteranganAkhirGanjilPAS as catatanPas'];
        } else {
            $selectAbsen = ['kelas_siswa.idSiswa', 'namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status', 'totalHadirGenap as totalHadir', 'totalSakitGenap as totalSakit', 'totalTanpaKeteranganGenap as totalTanpaKeterangan', 'totalIzinGenap as totalIzin', 'keteranganAkhirGenapPAS as catatanPas'];
        }

        $siswa = KelasSiswa::select($selectAbsen)
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $semester)
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $semester)
            ->where('siswa', $idSiswa)
            ->get();

        $listEkskul = Ekskul::where('idKelas', $idKelas)->where('idSiswa', $idSiswa)->get();

        $totalNilai = RekapPas::where('semester', $semester)
            ->where('siswa', $idSiswa)
            ->where('kelas', $idKelas)
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalMapel = count($rekapMapel);
        $avgAkademik = round($totalNilai->totalAkademik / $totalMapel, 2);
        $avgKeterampilan = round($totalNilai->totalKeterampilan / $totalMapel, 2);


        return view('Siswa/raportSiswa', [
            'siswa' => $siswa,
            'ekskul' => $listEkskul,
            'rekapMapel' => $rekapMapel,
            'pas' => $pas,
            'totalNilai' => $totalNilai,
            'avgAkademik' => $avgAkademik,
            'avgKeterampilan' => $avgKeterampilan
        ]);
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
