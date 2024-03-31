<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use App\Models\Pegawai;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $totalSiswa = Siswa::count();
        $akreditasi = Akreditasi::first();
        $totalGuru = Pegawai::count();
        $profile = ProfilSekolah::first();
        return view('Profile/profile', ['profile' => $profile, 'totalSiswa' => $totalSiswa, 'totalGuru' => $totalGuru, 'akreditasi' => $akreditasi]);
    }

    public function editProfileView()
    {
        $profile = ProfilSekolah::first();
        $tahunSekarang = date('Y');
        $optionTahun = array();

        for ($tahun = $tahunSekarang - 3; $tahun <= $tahunSekarang + 3; $tahun++) {
            $tahunMulai = $tahun;
            $tahunSelesai = $tahun + 1;
            $optionTahun[] = $tahunMulai . '/' . $tahunSelesai;
        }

        return view('Profile/editProfile', ['profile' => $profile, 'tahunAjar' => $optionTahun]);
    }

    public function handleEditProfile(Request $request)
    {
        $validated = $request->validate([
            'namaSekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:40',
            'namaKepalaSekolah' => 'required|string|max:255',
            'semester' => 'required|in:GENAP,GANJIL',
            'tahunBerdiri' => 'required|integer|min:1920|max:' . date('Y'),
            'nss' => 'required|string|max:40',
            'nipKepalaSekolah' => 'required|string|max:40',
            'tahunAjaran' => 'required|string|max:9',
            'alamat' => 'required|string',
        ]);

        $myProfile = ProfilSekolah::first();

        if (!$myProfile) {
            $myProfile = ProfilSekolah::create($validated);

            return redirect('dashboard')->with('success', 'Tambah Profile Berhasil Ditambahkan');
        }

        $myProfile->namaSekolah = $validated['namaSekolah'];
        $myProfile->npsn = $validated['npsn'];
        $myProfile->namaKepalaSekolah = $validated['namaKepalaSekolah'];
        $myProfile->alamat = $validated['alamat'];
        $myProfile->tahunAjaran = $validated['tahunAjaran'];
        $myProfile->semester = $validated['semester'];
        $myProfile->tahunBerdiri = $validated['tahunBerdiri'];
        $myProfile->nss = $validated['nss'];
        $myProfile->nipKepalaSekolah = $validated['nipKepalaSekolah'];

        $myProfile->save();

        return redirect('dashboard')->with('success', 'Edit Profile Berhasil Ditambahkan');
    }

    public function addLogo(Request $request)
    {
        $profile = ProfilSekolah::first();

        if (isset($profile->logo)) {
            Storage::delete("public/{$profile->logo}");
        }

        $fileName = Str::random(6) . '_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
        $profile->logo = $request->file('logo')->storeAs('logo', $fileName, 'public');

        $profile->save();
        return redirect('dashboard')->with('success', 'Tambah Logo Berhasil');
    }

    public function aturAkreditasSekolah()
    {
        $akreditasi = Akreditasi::first();

        return view('Profile/aturAkreditas', ['akreditasi' => $akreditasi]);
    }

    public function handleAturAkreditasSekolah(Request $request)
    {
        $validated = $request->validate([
            'tahunAkreditasi' => 'required|integer|min:1920|max:' . date('Y'),
            'nilaiAkreditasi' => 'required|integer|',
            'sebutan' => 'required|string|max:5',
        ]);

        $akreditasi = Akreditasi::first();

        if (!$akreditasi) {
            $akreditasi = Akreditasi::create($validated);

            return redirect('dashboard')->with('success', 'Akreditasi Berhasil Diatur');
        }

        $akreditasi->tahunAkreditasi = $validated['tahunAkreditasi'];
        $akreditasi->nilaiAkreditasi = $validated['nilaiAkreditasi'];
        $akreditasi->sebutan = $validated['sebutan'];


        $akreditasi->save();

        return redirect('dashboard')->with('success', 'Akreditasi Berhasil Diatur');
    }
}
