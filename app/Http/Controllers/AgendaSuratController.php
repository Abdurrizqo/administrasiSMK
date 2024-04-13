<?php

namespace App\Http\Controllers;

use App\Models\AgendaSurat;
use App\Models\DisposisiSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgendaSuratController extends Controller
{
    public function getAllAgendaSuratMasuk(Request $request)
    {
        $filterTanggalAwal = $request->query('tanggalAwal');
        $filterTanggalAkhir = $request->query('tanggalAkhir');

        if ($filterTanggalAwal && $filterTanggalAkhir) {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "MASUK")->whereBetween("tanggalAgenda", [$filterTanggalAwal, $filterTanggalAkhir])->orderBy("tanggalAgenda", 'desc')->paginate(10);
        } else {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "MASUK")->orderBy("tanggalAgenda", 'desc')->paginate(10);
        }

        return view('AgendaSurat/suratMasuk', ['listAgenda' => $listAgendaSurat]);
    }

    public function getAllAgendaSuratKeluar(Request $request)
    {
        $filterTanggalAwal = $request->query('tanggalAwal');
        $filterTanggalAkhir = $request->query('tanggalAkhir');

        if ($filterTanggalAwal && $filterTanggalAkhir) {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "KELUAR")->whereBetween("tanggalAgenda", [$filterTanggalAwal, $filterTanggalAkhir])->orderBy("tanggalAgenda", 'desc')->paginate(10);
        } else {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "KELUAR")->orderBy("tanggalAgenda", 'desc')->paginate(10);
        }

        return view('AgendaSurat/suratKeluar', ['listAgenda' => $listAgendaSurat]);

    }

    public function disposisiSurat(Request $request)
    {
        $validate = $request->validate(
            [
                'idAgendaSurat' => 'required|string|exists:agenda_surat,idAgendaSurat',
                'arahan' => 'required|string',
                'judulDisposisi' => 'required|string|max:80',
                'tujuan' => 'required|string|exists:pegawai,idPegawai'
            ]
        );

        $disposisiSurat = DisposisiSurat::create(
            [
                'idAgendaSurat' => $validate['idAgendaSurat'],
                'arahan' => $validate['arahan'],
                'arahan' => $validate['judulDisposisi'],
                'tujuan' => $validate['tujuan'],
            ]
        );
    }
}
