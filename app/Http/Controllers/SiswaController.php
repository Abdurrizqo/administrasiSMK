<?php

namespace App\Http\Controllers;

use App\Models\CatatanSiswa;
use App\Models\Ekskul;
use App\Models\Jurusan;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\RekapPas;
use App\Models\SertifikatSiswa;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Rap2hpoutre\FastExcel\FastExcel;

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
        ], [
            'unique' => 'data telah digunakan',
            'required' => 'form harus diisi',
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

        $catatanSiswa = CatatanSiswa::where('idSiswa', $idSiswa)->orderBy('created_at', 'desc')->get();
        $SertifikatSiswa = SertifikatSiswa::where('idSiswa', $idSiswa)->orderBy('created_at', 'desc')->get();

        return view('Siswa/detailSiswa', ['siswa' => $siswa, 'kelas' => $kelas, 'catatan' => $catatanSiswa, 'sertifikat' => $SertifikatSiswa]);
    }

    public function detailRaportSiswa($idSiswa, $idKelas, Request $request)
    {

        $semester = $request->query('semester') === "GENAP" ? "GENAP" : "GANJIL";

        if ($semester === "GANJIL") {
            $selectAbsen = ['kelas_siswa.idSiswa', 'kelas_siswa.idKelas', 'kelas_siswa.raportGanjil as dokumenRaport', 'namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status', 'totalHadirGanjil as totalHadir', 'totalSakitGanjil as totalSakit', 'totalTanpaKeteranganGanjil as totalTanpaKeterangan', 'totalIzinGanjil as totalIzin', 'keteranganAkhirGanjilPAS as catatanPas'];
        } else {
            $selectAbsen = ['kelas_siswa.idSiswa', 'kelas_siswa.idKelas', 'kelas_siswa.raportGenap as dokumenRaport', 'namaSiswa', 'nis', 'nisn', 'fotoSiswa', 'kelas_siswa.status', 'totalHadirGenap as totalHadir', 'totalSakitGenap as totalSakit', 'totalTanpaKeteranganGenap as totalTanpaKeterangan', 'totalIzinGenap as totalIzin', 'keteranganAkhirGenapPAS as catatanPas'];
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
        if ($totalNilai->totalMapel != 0) {
            $avgAkademik = round($totalNilai->totalAkademik / $totalMapel, 2);
        } else {
            $avgAkademik = 0;
        }

        if ($totalNilai->totalKeterampilan != 0) {
            $avgKeterampilan = round($totalNilai->totalKeterampilan / $totalMapel, 2);
        } else {
            $avgKeterampilan = 0;
        }


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
        $jurusan = Jurusan::where('isActive', true)->get();
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
        ], [
            'unique' => 'data telah digunakan',
            'required' => 'form harus diisi',
        ]);

        $siswa = Siswa::where('idSiswa', $idSiswa)->update($validate);

        if ($siswa) {
            return redirect()->route('detailSiswa', ['idSiswa' => $idSiswa])->with('success', 'Data Siswa Berhasil Diperbarui');
        }
        return redirect()->refresh()->withInput()->withErrors('error', 'Data Siswa Gagal Diperbarui');
    }

    public function imporSiswaFromExcelView()
    {
        return view("Siswa/importSiswa");
    }

    public function handleImporSiswaFromExcel(Request $request)
    {
        $validatedData = $request->validate([
            'dokumen' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'required' => "Form Tidak Boleh Kosong",
            'mimes' => "File Harus Berjenis Excel",
            'max' => "Ukuran Maksimal 5mb",
        ]);

        DB::beginTransaction();

        $collection = (new FastExcel)->import($validatedData['dokumen']);

        $errorMessages = [];

        foreach ($collection as $value) {
            try {
                Siswa::create([
                    'nis' => $value['nis'],
                    'nisn' => $value['nisn'],
                    'namaSiswa' => $value['nama_siswa'],
                    'tahunMasuk' => $value['tahun_masuk'],
                    'idJurusan' => $value['jurusan'],
                    'nikWali' => $value['nik_wali'],
                    'namaWali' => $value['nama_wali'],
                    'alamat' => $value['alamat'],
                    'hubunganKeluarga' => $value['hubungan_keluarga']
                ]);
            } catch (Throwable $e) {
                if ($e->errorInfo[1] === 1062) {
                    $errorMessages[] = "Gagal menambahkan siswa " . $value['nama_siswa'] . " : Data (NIS, NISN) telah ada di database.";
                } elseif ($e->errorInfo[1] === 1452) {
                    $errorMessages[] = "Gagal menambahkan siswa " . $value['nama_siswa'] . " : Id Jurusan Tidak Valid.";
                } elseif ($e->errorInfo[1] === 'HY000') {
                    $errorMessages[] = "Gagal menambahkan siswa " . $value['nama_siswa'] . " : Hubungan Keluarga harus bernilai ('Ayah', 'Ibu', 'Kakak', 'Paman', 'Lainnya').";
                } else {
                    $errorMessages[] = "Gagal menambahkan siswa " . $value['nama_siswa'] . " :" . $e->getMessage();
                }
            }
        }


        if (count($errorMessages) === 0) {
            DB::commit();
            return redirect()->back()->with(['success' => "Import Semua Data Berhasil"]);
        } else {
            DB::rollBack();
            return redirect()->back()->with(['error' => $errorMessages]);
        }
    }

    public function downloadRaport($filename)
    {
        $path = storage_path('app/dokumenRaport/' . $filename);

        if (file_exists($path)) {
            $response = Response::file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);

            return $response;
        } else {
            abort(404, 'File not found');
        }
    }

    public function addFotoSiswa($idSiswa, Request $request)
    {
        $siswa = Siswa::where('idSiswa', $idSiswa)->first();

        if (isset($siswa->fotoSiswa)) {
            Storage::delete("public/{$siswa->fotoSiswa}");
        }

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('fotoSiswa')->getClientOriginalExtension();
        $siswa->fotoSiswa = $request->file('fotoSiswa')->storeAs('fotoSiswa', $fileName, 'public');

        $siswa->save();
        return redirect()->back()->with('success', 'Tambah Foto Siswa Berhasil');
    }

    public function gantiStatusSiswa($idSiswa, Request $request)
    {
        try {
            $validate = $request->validate([
                'status' => 'required|string|in:pindah,lulus,aktif',
                'ijazah' => 'nullable|file|mimes:pdf|max:3000'
            ]);

            $tahunSekarang = Carbon::now()->year;
            $siswa = Siswa::where('idSiswa', $idSiswa)->first();

            if ($validate['status'] === "lulus") {

                if ($siswa->ijazahLulus) {
                    if (file_exists(storage_path('app/' . $siswa->ijazahLulus))) {
                        unlink(storage_path('app/' . $siswa->ijazahLulus));
                    }
                }

                $fileName = Str::random(6) . '_' . time() . '.' . $request->file('ijazah')->getClientOriginalExtension();
                $fileIjazah = $request->file('ijazah')->storeAs('ijazah', $fileName);

                Siswa::where('idSiswa', $idSiswa)
                    ->update([
                        'status' => $validate['status'],
                        'tahunLulus' => $tahunSekarang,
                        'ijazahLulus' => $fileIjazah,
                        'tahunPindah' => null
                    ]);
            } elseif ($validate['status'] === "aktif") {
                if ($siswa->ijazahLulus) {
                    if (file_exists(storage_path('app/' . $siswa->ijazahLulus))) {
                        unlink(storage_path('app/' . $siswa->ijazahLulus));
                    }
                }

                Siswa::where('idSiswa', $idSiswa)
                    ->update([
                        'status' => $validate['status'],
                        'tahunPindah' => null,
                        'tahunLulus' => null,
                        'ijazahLulus' => null
                    ]);
            } else {
                if ($siswa->ijazahLulus) {
                    if (file_exists(storage_path('app/' . $siswa->ijazahLulus))) {
                        unlink(storage_path('app/' . $siswa->ijazahLulus));
                    }
                }

                Siswa::where('idSiswa', $idSiswa)
                    ->update([
                        'status' => $validate['status'],
                        'tahunPindah' => $tahunSekarang,
                        'tahunLulus' => null,
                        'ijazahLulus' => null
                    ]);
            }

            return redirect()->back()->with(['success' => 'Ganti Status Siswa Berhasil']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function downloadIjazah($filename)
    {
        $path = storage_path('app/ijazah/' . $filename);

        if (file_exists($path)) {
            $response = Response::file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);

            return $response;
        } else {
            abort(404, 'File not found');
        }
    }
}
