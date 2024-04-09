<?php

namespace App\Http\Controllers;

use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\ProfilSekolah;
use App\Models\RekapPas;
use App\Models\RekapPts;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    public function rekapNilaiPerSiswa($idKelas, $idSiswa)
    {
        $profile = ProfilSekolah::first();

        $siswa = KelasSiswa::select(['namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status'])
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $profile['semester'])
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pts = RekapPts::where('kelas', $idKelas)
            ->where('semester', $profile['semester'])
            ->where('siswa', $idSiswa)
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $profile['semester'])
            ->where('siswa', $idSiswa)
            ->get();

        $totalNilaiPas = RekapPas::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile['semester'])
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalNilaiPts = RekapPts::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile['semester'])
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalMapel = count($rekapMapel);

        $avgpas = [
            "avgAkademik" => round($totalNilaiPas->totalAkademik / $totalMapel, 2),
            "avgKeterampilan" => round($totalNilaiPas->totalKeterampilan / $totalMapel, 2)
        ];

        $avgpts = [
            "avgAkademik" => round($totalNilaiPts->totalAkademik / $totalMapel, 2),
            "avgKeterampilan" => round($totalNilaiPts->totalKeterampilan / $totalMapel, 2)
        ];


        return view(
            'RekapNilai/rekapPerSiswa',
            [
                'siswa' => $siswa,
                'rekapMapel' => $rekapMapel,
                'pts' => $pts,
                'pas' => $pas,
                'semester' => $profile['semester'],
                'totalNilaiPas' => $totalNilaiPas,
                'totalNilaiPts' => $totalNilaiPts,
                'avgpas' => $avgpas,
                'avgpts' => $avgpts
            ]
        );
    }


    public function kelasSiswaView($idKelasMapel)
    {
        $kelasMapel = KelasMapel::select(['kelas', 'mapel', 'namaKelas', 'namaMataPelajaran', 'idKelasMapel', 'semester', 'tahunAjaran'])
            ->where("idKelasMapel", $idKelasMapel)
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_mapel.kelas')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->first();

        return view("RekapNilai/kelasSiswa", ['kelasMapel' => $kelasMapel]);
    }

    public function setKenaikanKelas($idKelas, $idSiswa, Request $request)
    {
        $validate = $request->validate(
            [
                'status' => 'required|string|in:TINGGAL KELAS,NAIK KELAS'
            ]
        );

        $siswa = KelasSiswa::where("idSiswa", $idSiswa)
            ->where("idKelas", $idKelas)
            ->update($validate);

        if ($siswa) {
            return redirect()->back()->with(['success' => 'Kenaikan Siswa Telah Di Tetapkan']);
        } else {
            return redirect()->back()->with(['error' => 'Kenasikan Siswa Gagal Di Tetapkan']);
        }
    }

    public function cetakRaportSiswa($idKelas, $idSiswa)
    {
        $profile = ProfilSekolah::first();

        $siswa = KelasSiswa::select(['namaSiswa', 'nis', 'nisn', 'namaKelas'])
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("kelas_siswa.idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_siswa.idKelas')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $profile['semester'])
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $profile['semester'])
            ->where('siswa', $idSiswa)
            ->get();

        $totalNilaiPas = RekapPas::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile['semester'])
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalMapel = count($rekapMapel);

        $avgpas = [
            "avgAkademik" => round($totalNilaiPas->totalAkademik / $totalMapel, 2),
            "avgKeterampilan" => round($totalNilaiPas->totalKeterampilan / $totalMapel, 2)
        ];

        $pdf = Pdf::loadView('pdf.raport', [
            'siswa' => $siswa,
            'rekapMapel' => $rekapMapel,
            'pas' => $pas,
            'semester' => $profile['semester'],
            'totalNilaiPas' => $totalNilaiPas,
            'avgpas' => $avgpas,
        ]);

        return $pdf->stream();
    }
}
