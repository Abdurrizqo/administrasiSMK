<?php

namespace App\Http\Controllers;

use App\Models\DisposisiSurat;
use App\Models\MessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
    public function listDisposisiSurat(Request $request)
    {
        $filterTanggalAwal = $request->query('tanggalAwal');
        $filterTanggalAkhir = $request->query('tanggalAkhir');

        if ($filterTanggalAwal && $filterTanggalAkhir) {
            $listDisposisi = DisposisiSurat::whereBetween("tanggalDisposisi", [$filterTanggalAwal, $filterTanggalAkhir])
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'tujuan')
                ->orderBy("disposisi_surat.created_at", 'desc')
                ->paginate(10);
        } else {
            $listDisposisi = DisposisiSurat::leftJoin('pegawai', 'pegawai.idPegawai', '=', 'tujuan')
                ->orderBy("disposisi_surat.created_at", 'desc')->paginate(10);
        }

        return view('Disposisi/listDisposisi', ['listDisposisi' => $listDisposisi]);
    }

    public function balasanDisposisi($idDisposisi)
    {
        $user = Auth::user()->idPegawai;
        $disposisi = DisposisiSurat::where('idDisposisi', $idDisposisi)
            ->leftJoin('agenda_surat', 'agenda_surat.idAgendaSurat', '=', 'disposisi_surat.idAgendaSurat')
            ->first();

        $loadChat = MessageModel::where('idDisposisi', $idDisposisi)->get();

        return view("Disposisi.detailDisposisi", ['disposisi' => $disposisi, 'loadChat' => $loadChat, 'user' => $user]);
    }
}
