<?php

namespace App\Http\Controllers;

use App\Models\DisposisiSurat;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function listDisposisiSurat(Request $request)
    {
        $filterTanggalAwal = $request->query('tanggalAwal');
        $filterTanggalAkhir = $request->query('tanggalAkhir');

        if ($filterTanggalAwal && $filterTanggalAkhir) {
            $listDisposisi = DisposisiSurat::whereBetween("tanggalDisposisi", [$filterTanggalAwal, $filterTanggalAkhir])
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'tujuan')
                ->orderBy("tanggalDisposisi", 'desc')
                ->paginate(10);
        } else {
            $listDisposisi = DisposisiSurat::leftJoin('pegawai', 'pegawai.idPegawai', '=', 'tujuan')
                ->orderBy("tanggalDisposisi", 'desc')->paginate(10);
        }

        return view('Disposisi/listDisposisi', ['listDisposisi' => $listDisposisi]);
    }
}
