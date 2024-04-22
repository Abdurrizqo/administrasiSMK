<?php

namespace App\Http\Controllers;

use App\Models\AgendaSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

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
            $response = Response::file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);

            return $response;
        } else {
            abort(404, 'File not found');
        }
    }

    public function exportSuratMasuk(Request $request)
    {
        if ($request->has('tanggalAwal') && $request->has('tanggalAkhir')) {
            $tanggalAwal = $request->query('tanggalAwal');
            $tanggalAkhir = $request->query('tanggalAkhir');

            $listAgendaSurat = AgendaSurat::select([
                'tanggalAgenda as Tanggal Surat Masuk',
                'tanggalSurat as Tanggal Surat',
                'nomerSurat as Nomer Surat',
                'perihal as Ringkasan',
                'asalTujuanSurat as Asal Surat',
                'hasDisposisi'
            ])->where("statusSurat", "MASUK")
                ->whereBetween("tanggalAgenda", [$tanggalAwal, $tanggalAkhir])
                ->orderBy("created_at", 'desc')
                ->get();

            $arrDoc = [];
            foreach ($listAgendaSurat as $item) {
                if (!$item->hasDisposisi) {
                    $item->hasDisposisi = "Belum Disposisi";
                } else {
                    $item->hasDisposisi = "Telah Disposisi";
                }
                $arrDoc[] = $item;
            }


            $header_style = (new Style())->setFontBold();
            $rows_style = (new Style())->setCellAlignment("center");

            return (new FastExcel($arrDoc))
                ->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download('Surat Masuk.xlsx');
        } else {
            return response()->json(['error' => 'Tanggal awal atau tanggal akhir tidak tersedia.'], 400);
        }
    }



    public function exportSuratKeluar(Request $request)
    {
        if ($request->has('tanggalAwal') && $request->has('tanggalAkhir')) {
            $tanggalAwal = $request->query('tanggal_awal');
            $tanggalAkhir = $request->query('tanggal_akhir');

            $listAgendaSurat = AgendaSurat::select([
                'tanggalAgenda as Tanggal Surat Keluar',
                'tanggalSurat as Tanggal Surat',
                'nomerSurat as Nomer Surat',
                'perihal as Ringkasan',
                'asalTujuanSurat as Tujuan'
            ])->where("statusSurat", "KELUAR")
                ->whereBetween("tanggalAgenda", [$tanggalAwal, $tanggalAkhir])
                ->orderBy("created_at", 'desc')
                ->get();

            $header_style = (new Style())->setFontBold();
            $rows_style = (new Style())->setCellAlignment("center");

            return (new FastExcel($listAgendaSurat))
                ->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download('Surat Keluar.xlsx');
        } else {
            return response()->json(['error' => 'Tanggal awal atau tanggal akhir tidak tersedia.'], 400);
        }
    }
}
