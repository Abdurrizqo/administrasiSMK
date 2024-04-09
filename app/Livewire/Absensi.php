<?php

namespace App\Livewire;

use App\Models\KelasSiswa;
use Livewire\Component;

class Absensi extends Component
{
    public $formTotalKehadiran;
    public $formTotalIzin;
    public $formTotalSakit;
    public $formTotalAbsen;
    public $idSiswa;
    public $idKelas;
    public $semester;
    public $successMsg;
    public $errorMsg;

    public function mount($semester)
    {
        $this->idKelas = request()->idKelas;
        $this->idSiswa = request()->idSiswa;
        $this->semester = $semester;
    }

    public function render()
    {
        if ($this->semester === "GANJIL") {
            $selectAbsen = ['totalHadirGanjil as totalHadir', 'totalSakitGanjil as totalSakit', 'totalTanpaKeteranganGanjil as totalTanpaKeterangan', 'totalIzinGanjil as totalIzin'];
        } else {
            $selectAbsen = ['totalHadirGenap as totalHadir', 'totalSakitGenap as totalSakit', 'totalTanpaKeteranganGenap as totalTanpaKeterangan', 'totalIzinGenap as totalIzin'];
        }

        $absensiSiswa = KelasSiswa::select($selectAbsen)
            ->where("idSiswa", $this->idSiswa)
            ->where("idKelas", $this->idKelas)
            ->first();

        $this->formTotalKehadiran = $absensiSiswa->totalHadir;
        $this->formTotalIzin = $absensiSiswa->totalIzin;
        $this->formTotalSakit = $absensiSiswa->totalSakit;
        $this->formTotalAbsen = $absensiSiswa->totalTanpaKeterangan;

        return view('livewire.absensi');
    }

    public function savePresensi()
    {
        $this->successMsg = null;
        $this->errorMsg = null;

        try {
            if ($this->semester === "GANJIL") {
                $updateAbsen = [
                    "totalHadirGanjil" => $this->formTotalKehadiran,
                    "totalSakitGanjil" => $this->formTotalSakit,
                    "totalTanpaKeteranganGanjil" => $this->formTotalAbsen,
                    "totalIzinGanjil" => $this->formTotalIzin,
                ];
            } else {
                $updateAbsen = [
                    "totalHadirGenap" => $this->formTotalKehadiran,
                    "totalSakitGenap" => $this->formTotalSakit,
                    "totalTanpaKeteranganGenap" => $this->formTotalAbsen,
                    "totalIzinGenap" => $this->formTotalIzin,
                ];
            }

            KelasSiswa::where("idSiswa", $this->idSiswa)
                ->where("idKelas", $this->idKelas)
                ->update($updateAbsen);

            $this->successMsg = "Update Presensi Berhasi";
        } catch (\Throwable $th) {
            $this->errorMsg = "Update Presensi Gagal";
        }
    }
}
