<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pegawai;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function listKelas(Request $request)
    {
        $allGuru = Pegawai::where('status', 'GURU')->orderBy('namaPegawai', 'asc')->get();
        $tahunSekarang = date('Y');
        $optionTahunAdd = array();

        for ($tahun = $tahunSekarang - 2; $tahun <= $tahunSekarang; $tahun++) {
            $tahunMulai = $tahun;
            $tahunSelesai = $tahun + 1;
            $optionTahunAdd[] = $tahunMulai . '/' . $tahunSelesai;
        }

        $optionTahunSearch = Kelas::select('tahunAjaran')->groupBy('tahunAjaran')->orderBy('tahunAjaran', 'asc')->get();

        $search = $request->query('search');
        $tahunAjar = $request->query('tahunAjar');

        if (empty($search) && empty($tahunAjar)) {
            $listKelas = Kelas::select([
                'idKelas',
                'waliKelas',
                'idPegawai',
                'namaKelas',
                'tahunAjaran',
                'namaPegawai',
                'isSync'
            ])
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas.waliKelas')
                ->paginate(10);
        } else {
            $query = Kelas::select([
                'idKelas',
                'idPegawai',
                'waliKelas',
                'namaKelas',
                'tahunAjaran',
                'isSync',
                'namaPegawai'
            ])
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas.waliKelas');

            $tahunAjar ? $query->where('tahunAjaran', $tahunAjar) : null;
            $search ? $query->where('namaKelas', 'like', "%$search%") : null;

            $query->paginate(10);

            $listKelas = $query->paginate(10);
        }

        return view('Kelas/listKelas', [
            'tahunAjarSearch' => $optionTahunSearch,
            'kelas' => $listKelas,
            'guru' => $allGuru,
            'tahunAjaranAdd' => $optionTahunAdd
        ]);
    }

    public function handleAddKelas(Request $request)
    {
        try {
            $validate = $request->validate([
                'tahunAjaran' => 'required|string|max:9',
                'namaKelas' => 'required|string|min:3',
                'waliKelas' => 'required|exists:pegawai,idPegawai|min:3'
            ], [
                'tahunAjaran.required' => 'Tahun Ajaran Tidak Boleh Kosong',
                'tahunAjaran.max' => 'Tahun Ajaran Tidak Valid',
                'namaKelas.required' => 'Nama Kelas Tidak Boleh Kosong',
                'namaKelas.min' => 'Nama Kelas Setidaknya 3 Karakter',
                'waliKelas.required' => 'Wali Kelas Tidak Boleh Kosong',
                'waliKelas.exists' => 'Wali Kelas Tidak Valid',
            ]);

            if (strpos($validate['namaKelas'], "'")) {
                throw new Error('Nama Kelas Tidak Boleh Menggunakan Tanda \'');
            }

            Kelas::create($validate);

            return redirect('dashboard/kelas')->with('success', 'Kelas Baru Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->refresh()->withInput()->with('error', "Kelas Baru Gagal Ditambahkan, $mesg");
        }
    }

    public function detailKelas($idKelas)
    {
        $routeUri = request()->route()->uri();
        $lastSegment = Str::of($routeUri)->explode('/')->last();

        $check = Kelas::where('idKelas', $idKelas)->first();

        if (!$check) {
            return abort(404);
        }

        return view('Kelas/detailKelas', ['idKelas' => $idKelas, 'semester' => $lastSegment]);
    }

    public function handleEditKelas(Request $request)
    {
        try {
            $validate = $request->validate([
                'idKelas' => 'required|string|exists:kelas,idKelas',
                'tahunAjaran' => 'required|string|max:9',
                'namaKelas' => 'required|string|min:3',
                'waliKelas' => 'required|exists:pegawai,idPegawai|min:3'
            ], [
                'idKelas.required' => 'ID Kelas Tidak Valid',
                'idKelas.exists' => 'ID Kelas Tidak Valid',
                'tahunAjaran.required' => 'Tahun Ajaran Tidak Boleh Kosong',
                'tahunAjaran.max' => 'Tahun Ajaran Tidak Valid',
                'namaKelas.required' => 'Nama Kelas Tidak Boleh Kosong',
                'namaKelas.min' => 'Nama Kelas Setidaknya 3 Karakter',
                'waliKelas.required' => 'Wali Kelas Tidak Boleh Kosong',
                'waliKelas.exists' => 'Wali Kelas Tidak Valid',
            ]);

            if (strpos($validate['namaKelas'], "'")) {
                throw new Error('Nama Kelas Tidak Boleh Menggunakan Tanda \'');
            }

            $kelas = Kelas::where('idKelas', $validate['idKelas'])->update($validate);

            if ($kelas) {
                return redirect('dashboard/kelas')->with('success', 'Data Kelas Berhasil Diperbarui');
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            return redirect()->refresh()->withInput()->with('error', "Data Kelas Gagal Diperbarui, $msg");
        }
    }

    public function deleteKelas($idKelas)
    {
        $kelas = Kelas::where('idKelas', $idKelas)->delete();

        if ($kelas) {
            return redirect('dashboard/kelas')->with('success', 'Data Kelas Berhasil Dihapus');
        }
        return redirect()->refresh()->withInput()->with('error', 'Data Kelas Gagal Dihapus');
    }

    public function tambahSiswaKelas($idKelas)
    {
        $kelas = Kelas::select(['tahunAjaran', 'namaKelas', 'idKelas'])->where('idKelas', $idKelas)->first();

        if (!$kelas) {
            return abort(404);
        }
        return view('Kelas/tambahSiswaKelas', ['idKelas' => $idKelas, 'kelas' => $kelas]);
    }
}
