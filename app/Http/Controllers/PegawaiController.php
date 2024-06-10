<?php

namespace App\Http\Controllers;

use App\Models\CatatanPegawai;
use App\Models\DisposisiSurat;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\Pegawai;
use App\Models\ProfilSekolah;
use App\Models\RekapPas;
use App\Models\RekapPts;
use App\Models\SertifikatPegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function GantiPasswordView()
    {
        return view('Pegawai/gantiPassword');
    }

    public function GantiPasswordTUView()
    {
        return view('Pegawai/gantiPasswordTU');
    }

    public function handleGantiPassword(Request $request)
    {
        $validate = $request->validate(
            [
                'username' => 'required|string',
                'password' => 'required|string',
                'passwordBaru' => 'required|string|min:6'
            ]
        );

        $user = User::where('username', $validate['username'])->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Ganti Password Gagal');
        }

        $userLogin = Auth::user();

        if ($user['idUser'] === $userLogin['idUser'] && Hash::check($validate['password'], $user['password'])) {
            $user['password'] = Hash::make($validate['passwordBaru']);
            $user->save();
            return redirect()->back()->with('success', 'Ganti Password Berhasil');
        }

        return redirect()->back()->with('error', 'Ganti Password Gagal');
    }

    public function gantiPhotoProfileView()
    {
        return view('pegawai.gantiProfile');
    }

    public function gantiPhotoProfile(Request $request)
    {
        $validate = $request->validate(
            [
                'photoProfile' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072'
            ]
        );

        $user = Auth::user();
        $myUser = User::where('idUser', $user->idUser)->first();

        if (isset($myUser->photoProfile)) {
            Storage::delete("public/{$myUser->photoProfile}");
        }

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('photoProfile')->getClientOriginalExtension();
        $myUser->photoProfile = $request->file('photoProfile')->storeAs('userProfile', $fileName, 'public');

        $myUser->save();

        Auth::setUser($myUser);
        return redirect('dashboard')->with('success', 'Ganti Foto Profile Berhasil');
    }

    public function gantiPhotoProfileGuruView()
    {
        return view('pegawai.gantiProfileGuru');
    }

    public function gantiPhotoProfileGuru(Request $request)
    {
        $validate = $request->validate(
            [
                'photoProfile' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072'
            ]
        );

        $user = Auth::user();
        $myUser = User::where('idUser', $user->idUser)->first();

        if (isset($myUser->photoProfile)) {
            Storage::delete("public/{$myUser->photoProfile}");
        }

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('photoProfile')->getClientOriginalExtension();
        $myUser->photoProfile = $request->file('photoProfile')->storeAs('userProfile', $fileName, 'public');

        $myUser->save();

        Auth::setUser($myUser);
        return redirect('home')->with('success', 'Ganti Foto Profile Berhasil');
    }

    public function detailPegawai($idPegawai)
    {
        $catatan = CatatanPegawai::where('idPegawai', $idPegawai)->orderBy('created_at', 'desc')->get();
        $sertifikat = SertifikatPegawai::where('idPegawai', $idPegawai)->orderBy('created_at', 'desc')->get();

        return view('Pegawai/detailPegawai', ['catatan' => $catatan, 'sertifikat' => $sertifikat, 'idPegawai' => $idPegawai]);
    }

    public function getAllPegawawi(Request $request)
    {
        try {
            $search = $request->query('search', '');

            if (!empty($search)) {
                $pegawai = Pegawai::where('namaPegawai', 'like', "%$search%")
                    ->orderBy('namaPegawai', 'asc')
                    ->get();
            } else {
                return response()->json(['error' => 'Nama Pegawai Tidak Valid'], 400);
            }

            return response()->json(['data' => $pegawai], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
