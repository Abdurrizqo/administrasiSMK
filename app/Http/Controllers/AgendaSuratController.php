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
            $listAgendaSurat = AgendaSurat::where("statusSurat", "MASUK")->whereBetween("tanggalAgenda", [$filterTanggalAwal, $filterTanggalAkhir])->orderBy("created_at", 'desc')->paginate(10);
        } else {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "MASUK")->orderBy("created_at", 'desc')->paginate(10);
        }

        return view('AgendaSurat/suratMasuk', ['listAgenda' => $listAgendaSurat]);
    }

    public function getAllAgendaSuratKeluar(Request $request)
    {
        $filterTanggalAwal = $request->query('tanggalAwal');
        $filterTanggalAkhir = $request->query('tanggalAkhir');

        if ($filterTanggalAwal && $filterTanggalAkhir) {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "KELUAR")->whereBetween("tanggalAgenda", [$filterTanggalAwal, $filterTanggalAkhir])->orderBy("created_at", 'desc')->paginate(10);
        } else {
            $listAgendaSurat = AgendaSurat::where("statusSurat", "KELUAR")->orderBy("created_at", 'desc')->paginate(10);
        }

        return view('AgendaSurat/suratKeluar', ['listAgenda' => $listAgendaSurat]);
    }

    public function downloadFileOnDokumen($filename)
    {
        $path = storage_path('app/dokumenSurat/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404, 'File not found');
        }
    }
}
