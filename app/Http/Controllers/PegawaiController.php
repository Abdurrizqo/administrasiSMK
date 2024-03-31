<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Pegawai;
use App\Models\ProfilSekolah;
use App\Models\RekapPas;
use App\Models\RekapPts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function listPegawai(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $pegawai = Pegawai::with('user')->paginate(10);
        } else {
            $pegawai = Pegawai::where('namaPegawai', 'like', "%$search%")->with('user')->paginate(10)->withQueryString();
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
        $dataPegawai = Pegawai::where('idPegawai', $user['idPegawai'])->first();
        $mataPelajaran = KelasMapel::where('tahunAjaran', $profile['tahunAjaran'])->where('semester', $profile['semester'])->where('guruMapel', $user['idPegawai'])->with('dataKelas')->with('dataMapel')->get();
        $waliKelas = Kelas::where('waliKelas', $user['idPegawai'])->where('tahunAjaran', $profile['tahunAjaran'])->where('semester', $profile['semester'])->get();
        return view('Pegawai/homePegawai', ['dataPegawai' => $dataPegawai, 'waliKelas' => $waliKelas, 'mapel' => $mataPelajaran]);
    }
}
