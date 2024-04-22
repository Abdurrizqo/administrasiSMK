<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\ProfilSekolah;
use App\Models\RekapPas;
use App\Models\RekapPts;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\SheetCollection;

use function PHPSTORM_META\type;

class RekapNilaiController extends Controller
{
    public function rekapNilaiPerSiswa($idKelas, $idSiswa)
    {
        $profile = ProfilSekolah::first();

        $siswa = KelasSiswa::select(['namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status', 'kelas_siswa.idSiswa'])
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pts = RekapPts::where('kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->where('siswa', $idSiswa)
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->where('siswa', $idSiswa)
            ->get();

        $totalNilaiPas = RekapPas::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile->semester)
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalNilaiPts = RekapPts::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile->semester)
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
                'semester' => $profile->semester,
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

        if ($profile->semester === "GANJIL") {
            $selectQuery = ['namaSiswa', 'nis', 'nisn', 'namaKelas', 'totalHadirGanjil', 'totalSakitGanjil', 'totalTanpaKeteranganGanjil', 'totalIzinGanjil', 'keteranganAkhirGanjilPAS'];
        } else {
            $selectQuery = ['namaSiswa', 'nis', 'nisn', 'namaKelas', 'totalHadirGenap', 'totalSakitGenap', 'totalTanpaKeteranganGenap', 'totalIzinGenap', 'keteranganAkhirGenapPAS'];
        }

        $siswa = KelasSiswa::select($selectQuery)
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("kelas_siswa.idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_siswa.idKelas')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->where('siswa', $idSiswa)
            ->get();

        $totalNilaiPas = RekapPas::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile->semester)
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
            'profilSekolah' => $profile,
            'totalNilaiPas' => $totalNilaiPas,
            'avgpas' => $avgpas,
        ])->setPaper('f4', 'landscape');

        return $pdf->download();
    }

    public function rekapNilaiSiswaExcel($idKelas, $idSiswa)
    {
        $profile = ProfilSekolah::first();

        if ($profile->semester === "GANJIL") {
            $selectQuery = ['namaSiswa', 'nis', 'nisn', 'namaKelas', 'totalHadirGanjil as totalHadir', 'totalSakitGanjil as totalSakit', 'totalTanpaKeteranganGanjil as totalTanpaKeterangan', 'totalIzinGanjil as totalIzin', 'keteranganAkhirGanjilPAS as keteranganAkhir'];
        } else {
            $selectQuery = ['namaSiswa', 'nis', 'nisn', 'namaKelas', 'totalHadirGenap as totalHadir', 'totalSakitGenap as totalSakit', 'totalTanpaKeteranganGenap as totalTanpaKeterangan', 'totalIzinGenap as totalIzin', 'keteranganAkhirGenapPAS as keteranganAkhir'];
        }

        //Sheet Satu
        $siswa = KelasSiswa::select($selectQuery)
            ->where("kelas_siswa.idSiswa", $idSiswa)
            ->where("kelas_siswa.idKelas", $idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_siswa.idKelas')
            ->first();

        $rekapMapel = KelasMapel::where('kelas_mapel.kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $pas = RekapPas::where('kelas', $idKelas)
            ->where('semester', $profile->semester)
            ->where('siswa', $idSiswa)
            ->get();

        $totalNilaiPas = RekapPas::where('kelas', $idKelas)
            ->where('siswa', $idSiswa)
            ->where('semester', $profile->semester)
            ->selectRaw('SUM(nilaiAkademik) as totalAkademik, SUM(nilaiKeterampilan) as totalKeterampilan')
            ->first();

        $totalMapel = count($rekapMapel);

        $avgpas = [
            "avgAkademik" => round($totalNilaiPas->totalAkademik / $totalMapel, 2),
            "avgKeterampilan" => round($totalNilaiPas->totalKeterampilan / $totalMapel, 2)
        ];

        $result = [];
        foreach ($rekapMapel as  $item) {
            $found = false;

            foreach ($pas as $value) {
                if ($item->idKelasMapel === $value->kelasMapel) {
                    $result[] = [
                        'Mata Pelajaran' => $item->namaMataPelajaran,
                        'Nilai Akademik' => $value->nilaiAkademik,
                        'Terbaca Nilai Akademik' => $value->terbilangNilaiAkademik,
                        'Nilai Keterampilan' => $value->nilaiKeterampilan,
                        'Terbaca Nilai Keterampilan' => $value->terbilangNilaiKeterampilan,
                        'Keterangan Hasil Mata Pelajaran' => $value->keterangan ? $value->keterangan : "",
                    ];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $result[] = [
                    'Mata Pelajaran' => $item->namaMataPelajaran,
                    'Nilai Akademik' => 0,
                    'Terbaca Nilai Akademik' => "Nol",
                    'Nilai Keterampilan' => 0,
                    'Terbaca Nilai Keterampilan' => "Nol",
                    'Keterangan Hasil Mata Pelajaran' => "",
                ];
            }
        }

        $dataSiswa = [[
            "Nama Siswa" => $siswa->namaSiswa,
            "NIS" => $siswa->nis,
            "NISN" => $siswa->nisn,
            "Nama Kelas" => $siswa->namaKelas,
            "Total Hadir" => $siswa->totalHadir,
            "Total Sakit" => $siswa->totalSakit,
            "Total Tanpa Keterangan" => $siswa->tanpaKeterangan ? $siswa->tanpaKeterangan : 0,
            "Total Izin" => $siswa->izin ? $siswa->izin : 0,
            "Total Nilai Akademik" => $totalNilaiPas->totalAkademik,
            "Total Nilai Keterampilan" => $totalNilaiPas->totalKeterampilan,
            "Rata-Rata Nilai Akademik" => $avgpas['avgAkademik'],
            "Rata-Rata Nilai Keterampilan" => $avgpas['avgKeterampilan'],
            "Keterangan Hasil Mata Pelajaran" => $siswa->keteranganAkhir ? $siswa->keteranganAkhir : "",
        ]];

        $sheets = new SheetCollection([
            $dataSiswa,
            $result
        ]);

        $header_style = (new Style())->setFontBold();

        $rows_style = (new Style())->setCellAlignment("center");

        return (new FastExcel($sheets))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download("rekap siswa.xlsx");

        return response()->json($dataSiswa);
    }

    public function rekapNilaiKelasExcel()
    {
        try {
            $user = Auth::user();
            $profile = ProfilSekolah::first();
            $kelas = Kelas::select(['namaKelas', 'idKelas'])
                ->where('waliKelas', $user->idPegawai)
                ->where('tahunAjaran', $profile->tahunAjaran)
                ->first();

            $rekapKelas = RekapPas::select('siswa')
                ->selectRaw('SUM(nilaiAkademik) as totalNilaiAkademik')
                ->selectRaw('SUM(nilaiKeterampilan) as totalNilaiKeterampilan')
                ->where('kelas', $kelas->idKelas)
                ->where('semester', $profile->semester)
                ->groupBy('siswa')
                ->get();

            if ($profile->semester === "GANJIL") {
                $selectQuery = ['kelas_siswa.idSiswa', 'siswa.namaSiswa', 'totalHadirGanjil', 'totalSakitGanjil', 'totalTanpaKeteranganGanjil', 'totalIzinGanjil'];
            } else {
                $selectQuery = ['kelas_siswa.idSiswa', 'siswa.namaSiswa', 'totalHadirGenap', 'totalSakitGenap', 'totalTanpaKeteranganGenap', 'totalIzinGenap'];
            }

            $dataSiswa = KelasSiswa::select($selectQuery)
                ->where('idKelas', $kelas->idKelas)
                ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
                ->get();

            $totalMapel = KelasMapel::where('kelas_mapel.kelas', $kelas->idKelas)
                ->where('semester', $profile->semester)
                ->count();

            $result = array();

            foreach ($dataSiswa as $item) {
                $found = false;

                foreach ($rekapKelas as $value) {
                    if ($item->idSiswa === $value->siswa) {
                        $avgAkademik = round($value->totalNilaiAkademik / $totalMapel, 2);
                        $avgKeterampilan = round($value->totalNilaiKeterampilan / $totalMapel, 2);

                        $result[] = [
                            "Nama Siswa" => $item->namaSiswa,
                            "Total Kehadiran" => $profile->semester === "GANJIL" ? $item->totalHadirGanjil : $item->totalHadirGenap,
                            "Total Sakit" => $profile->semester === "GANJIL" ? $item->totalSakitGanjil : $item->totalSakitGenap,
                            "Total Tanpa Keterangan" => $profile->semester === "GANJIL" ? $item->totalTanpaKeteranganGanjil : $item->totalTanpaKeteranganGenap,
                            "Total Izin" => $profile->semester === "GANJIL" ? $item->totalIzinGanjil : $item->totalIzinGenap,
                            "Jumlah Nilai Akademik" => $value->totalNilaiAkademik,
                            "Jumlah Nilai Keterampilan" => $value->totalNilaiKeterampilan,
                            "Rata-Rata Nilai Akademik" => $avgAkademik,
                            "Rata-Rata Nilai Keterampilan" => $avgKeterampilan,
                        ];

                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $result[] = [
                        "Nama Siswa" => $item->namaSiswa,
                        "Total Kehadiran" => $profile->semester === "GANJIL" ? $item->totalHadirGanjil : $item->totalHadirGenap,
                        "Total Sakit" => $profile->semester === "GANJIL" ? $item->totalSakitGanjil : $item->totalSakitGenap,
                        "Total Tanpa Keterangan" => $profile->semester === "GANJIL" ? $item->totalTanpaKeteranganGanjil : $item->totalTanpaKeteranganGenap,
                        "Total Izin" => $profile->semester === "GANJIL" ? $item->totalIzinGanjil : $item->totalIzinGenap,
                        "Total Nilai Akademik" => 0,
                        "Total Nilai Keterampilan" => 0,
                        "Rata-Rata Nilai Akademik" => 0,
                        "Rata-Rata Nilai Keterampilan" => 0,
                    ];
                }
            }


            $header_style = (new Style())->setFontBold();

            $rows_style = (new Style())->setCellAlignment("center");

            return (new FastExcel($result))
                ->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download("raport.xlsx");
        } catch (\Throwable $th) {
            return response()->json(['err' => $th->getMessage()]);
        }
    }
}
