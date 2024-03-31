<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Error;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function listMapel(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $listMapel = MataPelajaran::get();
        } else {
            $listMapel = MataPelajaran::where('namaMataPelajaran', 'like', "%$search%")->get();
        }
        return view('Mapel/listMapel', ['mapel' => $listMapel]);
    }

    public function addMapel(Request $request)
    {
        try {
            $validate = $request->validate([
                'namaMataPelajaran' => 'required|string|max:255'
            ], [
                'namaMataPelajaran.required' => 'Nama Mata Pelajaran Wajib Di isi'
            ]);

            if (strpos($validate['namaMataPelajaran'], "'")) {
                throw new Error('Nama Mata Pelajaran Tidak Boleh Menggunakan Tanda \'');
            }

            MataPelajaran::create($validate);

            return redirect()->refresh()->withInput()->with('success', 'Mata Pelajaran Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->refresh()->withInput()->with('error', "Mata Pelajaran Gagal Ditambahkan, $mesg");
        }
    }

    public function editMapel(Request $request)
    {
        try {
            $validate = $request->validate([
                'namaMataPelajaran' => 'required|string|max:255',
                'idMataPelajaran' => 'required|string|exists:mata_pelajaran,idMataPelajaran'
            ], [
                'namaMataPelajaran.required' => 'Nama Mata Pelajaran Wajib Di isi',
                'idMataPelajaran.required' => 'Id Tidak Valid',
                'idMataPelajaran.exists' => 'Id Tidak Valid',
            ]);

            if (strpos($validate['namaMataPelajaran'], "'")) {
                throw new Error('Nama Mata Pelajaran Tidak Boleh Menggunakan Tanda \'');
            }

            MataPelajaran::where('idMataPelajaran', $validate['idMataPelajaran'])->update($validate);

            return redirect()->back()->with('success', 'Edit Mata Pelajaran Berhasil');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Edit Mata Pelajaran Gagal, $mesg");
        }
    }
}
