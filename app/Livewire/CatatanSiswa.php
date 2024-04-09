<?php

namespace App\Livewire;

use App\Models\KelasSiswa;
use Livewire\Component;

class CatatanSiswa extends Component
{
    public $isModalPasOpen = false;
    public $isModalPtsOpen = false;

    public $catatanPts;
    public $catatanPas;

    public $idSiswa;
    public $idKelas;
    public $semester;

    public $mesgSuccess = false;
    public $mesgError = false;

    public function mount($semester)
    {
        $this->idKelas = request()->idKelas;
        $this->idSiswa = request()->idSiswa;
        $this->semester = $semester;
    }

    public function render()
    {
        if ($this->semester === "GANJIL") {
            $selectCatatan = ['keteranganAkhirGanjilPTS as catatanPts', 'keteranganAkhirGanjilPAS as catatanPas'];
        } else {
            $selectCatatan = ['keteranganAkhirGenapPTS as catatanPts', 'keteranganAkhirGenapPAS as catatanPas'];
        }

        $catatanSiswa = KelasSiswa::select($selectCatatan)
            ->where("idSiswa", $this->idSiswa)
            ->where("idKelas", $this->idKelas)
            ->first();

        $this->catatanPas = $catatanSiswa->catatanPas;
        $this->catatanPts = $catatanSiswa->catatanPts;

        return view('livewire.catatan-siswa');
    }

    public function openModalPas()
    {
        $this->mesgError = false;
        $this->mesgSuccess = false;
        $this->isModalPasOpen = true;
    }

    public function openModalPts()
    {
        $this->mesgError = false;
        $this->mesgSuccess = false;
        $this->isModalPtsOpen = true;
    }

    public function closeModalPas()
    {
        $this->mesgError = false;
        $this->mesgSuccess = false;
        $this->isModalPasOpen = false;
    }

    public function closeModalPts()
    {
        $this->mesgError = false;
        $this->mesgSuccess = false;
        $this->isModalPtsOpen = false;
    }

    public function saveCatatanPts()
    {
        if ($this->semester === "GANJIL") {
            $check = KelasSiswa::where("idSiswa", $this->idSiswa)
                ->where("idKelas", $this->idKelas)
                ->update(["keteranganAkhirGanjilPTS" => $this->catatanPts]);
        } else {
            $check = KelasSiswa::where("idSiswa", $this->idSiswa)
                ->where("idKelas", $this->idKelas)
                ->update(["keteranganAkhirGenapPTS" => $this->catatanPts]);
        }

        if ($check) {
            $this->mesgSuccess = true;
        } else {
            $this->mesgError = true;
        }
    }

    public function saveCatatanPas()
    {
        if ($this->semester === "GANJIL") {
            $check = KelasSiswa::where("idSiswa", $this->idSiswa)
                ->where("idKelas", $this->idKelas)
                ->update(["keteranganAkhirGanjilPAS" => $this->catatanPas]);
        } else {
            $check = KelasSiswa::where("idSiswa", $this->idSiswa)
                ->where("idKelas", $this->idKelas)
                ->update(["keteranganAkhirGenapPAS" => $this->catatanPas]);
        }

        if ($check) {
            $this->mesgSuccess = true;
        } else {
            $this->mesgError = true;
        }
    }
}
