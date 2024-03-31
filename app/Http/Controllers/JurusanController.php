<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Error;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function listJurusan()
    {
        $listJurusan = Jurusan::get();
        return view('Jurusan/listJurusan', ['jurusan' => $listJurusan]);
    }

    public function addJurusan(Request $request)
    {
        try {
            $validate = $request->validate([
                'namaJurusan' => 'required|string|max:255'
            ], [
                'namaJurusan.required' => 'Nama Jurusan Harus Di Isi',
            ]);

            if (strpos($validate['namaJurusan'], "'")) {
                throw new Error('Nama Mata Pelajaran Tidak Boleh Menggunakan Tanda \'');
            }

            Jurusan::create($validate);

            return redirect()->refresh()->withInput()->with('success', 'Jurusan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->refresh()->withInput()->with('error', "Jurusan Gagal Ditambahkan, $mesg");
        }
    }

    public function editJurusan(Request $request)
    {

        try {
            $validate = $request->validate([
                'namaJurusan' => 'required|string|max:255|',
                'idJurusan' => 'required|string|exists:jurusan,idJurusan'
            ], [
                'namaJurusan.required' => 'Nama Jurusan Harus Di Isi',
                'idJurusan.required' => 'ID Tidak Valid',
                'idJurusan.exists' => 'ID Tidak Valid',
            ]);

            if (strpos($validate['namaJurusan'], "'")) {
                throw new Error('Nama Mata Pelajaran Tidak Boleh Menggunakan Tanda \'');
            }

            Jurusan::where('idJurusan', $validate['idJurusan'])->update($validate);

            return redirect()->back()->with('success', 'Edit Jurusan Berhasil');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Edit Jurusan Gagal, $mesg");
        }
    }

    public function ubahStatusJurusan($idJurusan)
    {
        $jurusan = Jurusan::where('idJurusan', $idJurusan)->first();
        $jurusan['isActive'] = !$jurusan['isActive'];
        $jurusan = $jurusan->save();

        if ($jurusan) {
            return redirect()->back()->with('success', 'Status Jurusan Berhasil Di Ubah');
        }
        return redirect()->back()->with('error', 'Status Jurusan Gagal Di Ubah');
    }
}
