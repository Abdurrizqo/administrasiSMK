<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JurnalKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;

class JurnalKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggalMulai') ?? Carbon::today()->toDateString();
        $tanggalAkhir = $request->input('tanggalAkhir') ?? Carbon::today()->toDateString();

        if ($tanggalAkhir < $tanggalMulai) {
            $tanggalAkhir = $tanggalMulai;
        }

        $jurnalKegiatan = JurnalKegiatan::select(['pegawai.namaPegawai', 'pegawai.idPegawai', 'jurnal_kegiatan.*'])
            ->whereDate('tanggalDibuat', '>=', $tanggalMulai)
            ->whereDate('tanggalDibuat', '<=', $tanggalAkhir)
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'jurnal_kegiatan.penulisKegiatan')
            ->orderBy('tanggalDibuat', 'desc')
            ->get();

        return view("JurnalKegiatan.jurnalKegiatan", [
            'jurnalKegiatan' => $jurnalKegiatan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir
        ]);
    }

    public function storeView()
    {
        return view('JurnalKegiatan.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'materiKegiatan' => 'required|string',
                'Hasil' => 'required|string',
                'Hambatan' => 'required|string',
                'Solusi' => 'required|string',
                'tanggalDibuat' => 'nullable|date_format:Y-m-d\TH:i',
            ],
            [
                'required' => 'Form Harus Di Isi',
            ]
        );

        try {
            $user = Auth::user();

            JurnalKegiatan::create(
                [
                    'materiKegiatan' => $validate['materiKegiatan'],
                    'Hasil' => $validate['Hasil'],
                    'Hambatan' => $validate['Hambatan'],
                    'Solusi' => $validate['Solusi'],
                    'tanggalDibuat' => $validate['tanggalDibuat'] ?? now(),
                    'penulisKegiatan' => $user->idPegawai,
                ]
            );

            return redirect('dashboard/jurnal-kegiatan')->with('success', 'Jurnal Kegiatan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            $mesg = $th->getMessage();
            return redirect()->back()->with('error', "Jurnal Kegiatan Gagal Ditambahkan, $mesg");
        }
    }

    public function exportJurnal(Request $request)
    {
        $tanggalMulai = $request->input('tanggalMulai') ? Carbon::parse($request->input('tanggalMulai'))->toDateString() : Carbon::today()->toDateString();
        $tanggalAkhir = $request->input('tanggalAkhir') ? Carbon::parse($request->input('tanggalAkhir'))->toDateString() : Carbon::today()->toDateString();

        if ($tanggalAkhir < $tanggalMulai) {
            $tanggalAkhir = $tanggalMulai;
        }

        $jurnalKegiatan = JurnalKegiatan::select([
            'jurnal_kegiatan.tanggalDibuat as Tanggal Dibuat',
            'pegawai.namaPegawai as Nama Pegawai',
            'jurnal_kegiatan.materiKegiatan as Materi Kegiatan',
            'jurnal_kegiatan.Hasil as Hasil',
            'jurnal_kegiatan.Hambatan as Hambatan',
            'jurnal_kegiatan.Solusi as Solusi',
        ])
            ->whereDate('tanggalDibuat', '>=', $tanggalMulai)
            ->whereDate('tanggalDibuat', '<=', $tanggalAkhir)
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'jurnal_kegiatan.penulisKegiatan')
            ->orderBy('tanggalDibuat', 'desc')
            ->get();

        $header_style = (new Style())->setFontBold();
        $rows_style = (new Style())->setCellAlignment("center");

        return (new FastExcel($jurnalKegiatan))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download('Jurnal_Kegiatan.xlsx');
    }
}
