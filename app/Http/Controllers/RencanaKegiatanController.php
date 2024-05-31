<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RencanaKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RencanaKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        if (empty($search)) {
            $rencanaKegiatan = RencanaKegiatan::select(['pegawai.namaPegawai', 'pegawai.idPegawai', 'rencana_kegiatan.*'])
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'rencana_kegiatan.ketuaPelaksana')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            $rencanaKegiatan = RencanaKegiatan::select(['pegawai.namaPegawai', 'pegawai.idPegawai', 'rencana_kegiatan.*'])
                ->where('namaKegiatan', 'like', "%$search%")
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'rencana_kegiatan.ketuaPelaksana')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        $user = Auth::user();
        $backNavigate = ($user->role === 'TU') ? 'dashboard' : 'home';
        return view('RencanaKegiatan.rencanaKegiatan', ['rencanaKegiatan' => $rencanaKegiatan, 'backNavigate' => $backNavigate]);
    }

    public function storeView()
    {
        $user = Auth::user();
        $dataKetua = Pegawai::where('idPegawai', $user->idPegawai)->first();

        $user = Auth::user();
        $backNavigate = ($user->role === 'TU') ? 'dashboard' : 'home';
        return view('RencanaKegiatan.createRencanaKegiatan', ['dataKetua' => $dataKetua, 'backNavigate' => $backNavigate]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'tanggalMulaiKegiatan' => 'required|date',
            'namaKegiatan' => 'required|string|min:3|max:255',
            'ketuaPelaksana' => 'required|string|exists:pegawai,idPegawai',
            'wakilKetuaPelaksana' => 'required|string|exists:pegawai,namaPegawai',
            'sekretaris' => 'required|string|exists:pegawai,namaPegawai',
            'bendahara' => 'required|string|exists:pegawai,namaPegawai',
            'dokumenProposal' => 'required|file|mimes:pdf|max:10000',
        ], [
            'required' => 'Form Harus Di Isi',
            'max' => 'Nilai Terlalu Panjang',
            'sertifikat.max' => 'Maksimum ukuran berkas adalah 10MB',
            'exists' => 'Data pegawai tidak ditemukan',
        ]);

        try {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('dokumenProposal')->getClientOriginalExtension();
            $validate['dokumenProposal'] = $request->file('dokumenProposal')->storeAs('kegiatan', $fileName, 'public');

            RencanaKegiatan::create($validate);
            return redirect()->back()->with('success', 'Rencana Kegiatan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Rencana Kegiatan Gagal Ditambahkan, $mesg");
        }
    }

    public function show($id)
    {
        $rencanaKegiatan = RencanaKegiatan::select(['pegawai.namaPegawai', 'pegawai.idPegawai', 'rencana_kegiatan.*'])
            ->where('idRencanaKegiatan', $id)
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'rencana_kegiatan.ketuaPelaksana')
            ->first();

        if (!$rencanaKegiatan) {
            return abort(404);
        }

        $user = Auth::user();
        $backNavigate = ($user->role === 'TU') ? 'dashboard' : 'home';
        return view('RencanaKegiatan.detail', ['rencanaKegiatan' => $rencanaKegiatan, 'backNavigate' => $backNavigate]);
    }

    public function update($id, Request $request)
    {
        $rencanaKegiatan = RencanaKegiatan::where('idRencanaKegiatan', $id)
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'rencana_kegiatan.ketuaPelaksana')
            ->first();

        $user = Auth::user();
        if ($rencanaKegiatan->ketuaPelaksana !== $user->idPegawai) {
            return redirect()->back()->with('error', "Rencana Kegiatan Hanya Dapat Diselesaikan Oleh Ketua Pelaksana");
        }

        $validate = $request->validate([
            'tanggalSelesaiKegiatan' => 'required|date',
            'dokumenLaporanHasil' => 'required|file|mimes:pdf|max:10000',
        ], [
            'required' => 'Form Harus Di Isi',
            'sertifikat.max' => 'Maksimum ukuran berkas adalah 10MB',
        ]);

        try {
            $fileName = Str::random(6) . '_' . time() . '.' . $request->file('dokumenLaporanHasil')->getClientOriginalExtension();
            $validate['dokumenLaporanHasil'] = $request->file('dokumenLaporanHasil')->storeAs('kegiatan', $fileName, 'public');

            $rencanaKegiatan->tanggalSelesaiKegiatan = $validate['tanggalSelesaiKegiatan'];
            $rencanaKegiatan->dokumenLaporanHasil = $validate['dokumenLaporanHasil'];
            $rencanaKegiatan->isFinish = true;
            $rencanaKegiatan->save();

            return redirect()->back()->with('success', 'Rencana Kegiatan Berhasil Diselesaikan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Rencana Kegiatan Gagal Diselesaikan, $mesg");
        }
    }
}
