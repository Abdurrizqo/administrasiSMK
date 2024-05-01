<?php

namespace App\Http\Controllers;

use App\Models\DisposisiSurat;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\Pegawai;
use App\Models\ProfilSekolah;
use App\Models\RekapPas;
use App\Models\RekapPts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function listPegawai(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $pegawai = Pegawai::where('isActive', true)->with('user')->orderBy('namaPegawai', 'asc')->paginate(10);
        } else {
            $pegawai = Pegawai::where('isActive', true)->where('namaPegawai', 'like', "%$search%")->orderBy('namaPegawai', 'asc')->with('user')->paginate(10)->withQueryString();
        }

        return view('Pegawai/pegawai', ['pegawai' => $pegawai]);
    }

    public function addPegawaiView()
    {
        return view('Pegawai/tambahPegawai');
    }

    public function handleAddPegawai(Request $request)
    {
        $validate = $request->validate([
            'namaPegawai' => 'required|min:3',
            'nipy' => 'required|unique:pegawai,nipy|min:3',
            'status' => ['required', 'in:TU,GURU']
        ], [
            'required' => 'form harus diisi',
            'min' => 'data minimal 3 karakter',
            'in' => 'data harus bernilai TU atau GURU',
        ]);

        $newPegawai = Pegawai::create($validate);

        if ($newPegawai) {
            return redirect('dashboard/pegawai')->with('success', 'Pegawai Berhasil Ditambahkan');
        }
        return redirect()->refresh()->withInput()->with('error', 'Pegawai Gagal Ditambahkan');
    }

    public function editPegawaiView($idPegawai)
    {
        $pegawai = Pegawai::where('idPegawai', $idPegawai)->first();
        return view('Pegawai/editPegawai', ['pegawai' => $pegawai]);
    }

    public function handleEditPegawai($idPegawai, Request $request)
    {
        $validate = $request->validate([
            'namaPegawai' => 'required|min:3',
            'nipy' => 'required|unique:pegawai,nipy,' . $idPegawai . ',idPegawai|min:3',
            'status' => ['required', 'in:TU,GURU']
        ], [
            'required' => 'form harus diisi',
            'min' => 'data minimal 3 karakter',
            'in' => 'data harus bernilai TU atau GURU',
            'unique' => 'data telah digunakan',
        ]);

        $pegawai = Pegawai::where('idPegawai', $idPegawai)->update($validate);

        if ($pegawai) {
            return redirect('dashboard/pegawai')->with('success', 'Edit Pegawai Berhasil Tersimpan');
        }
        return redirect()->refresh()->withInput()->with('error', 'Edit Pegawai Gagal Tersimpan');
    }

    public function addUserPegawai(Request $request)
    {
        $validate = $request->validate([
            'username' => 'unique:users',
        ], [
            'unique' => 'data telah digunakan'
        ]);

        $avaibleUser = User::where('idPegawai', $request->idPegawai)->first();

        if ($avaibleUser) {
            $avaibleUser->username = $request->username;
            $avaibleUser->password = Hash::make($request->password);
            $avaibleUser->save();

            if ($avaibleUser) {
                return redirect('dashboard/pegawai')->with('success', 'Update Akun Berhasil Ditambahkan');
            }
            return redirect()->refresh()->withInput()->withErrors('error', 'Update Akun Gagal Ditambahkan');
        }

        $pengawai = Pegawai::find($request->idPegawai);

        $newUser = User::create([
            'username' => $validate['username'],
            'password' => Hash::make($request->password),
            'role' => $request->status,
            'idPegawai' => $request->idPegawai
        ]);

        $pengawai->idUser = $newUser['idUser'];
        $pengawai->save();

        if ($newUser) {
            return redirect('dashboard/pegawai')->with('success', 'Akun Baru Berhasil Ditambahkan');
        }
        return redirect()->refresh()->withInput()->withErrors('error', 'Akun Baru Gagal Ditambahkan');
    }

    public function homePegawaiView()
    {
        $user = Auth::user();
        $profile = ProfilSekolah::first();
        $mataPelajaran = KelasMapel::select(['kelas', 'idKelasMapel', 'mapel', 'mata_pelajaran.namaMataPelajaran', 'kelas.namaKelas'])
            ->where('tahunAjaran', $profile['tahunAjaran'])
            ->where('semester', $profile['semester'])
            ->where('guruMapel', $user['idPegawai'])
            ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_mapel.kelas')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->get();

        $waliKelas = Kelas::select(['namaKelas', 'idKelas'])
            ->where('waliKelas', $user['idPegawai'])
            ->where('tahunAjaran', $profile['tahunAjaran'])
            ->first();

        $siswa = null;
        if ($waliKelas) {
            $siswa = KelasSiswa::select(['siswa.namaSiswa', 'siswa.nis', 'siswa.nisn', 'kelas_siswa.idSiswa'])
                ->where('idKelas', $waliKelas['idKelas'])
                ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
                ->get();
        }

        $disposisi = DisposisiSurat::where('tujuan', $user->idPegawai)->get();

        return view('Pegawai/homePegawai', ['kelasDiampu' => $mataPelajaran, 'waliKelas' => $waliKelas, 'siswa' => $siswa, 'profileSekolah' => $profile, 'disposisi' => $disposisi]);
    }

    public function deletePegawai($idPegawai)
    {
        try {
            DB::beginTransaction();
            Pegawai::where('idPegawai', $idPegawai)->update(['isActive' => false]);
            User::where('idPegawai', $idPegawai)->delete();
            DB::commit();
            return redirect('dashboard/pegawai')->with('success', 'Hapus Pegawai Berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->refresh()->withInput()->with('error', 'Hapus Pegawai Gagal' . $th->getMessage());
        }
    }
}
