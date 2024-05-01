<?php

namespace App\Livewire;

use App\Models\Ekskul as ModelsEkskul;
use Livewire\Component;

class Ekskul extends Component
{
    public $isModalOpen = false;

    public $ekskul;

    public $formNamaEkskul;
    public $formNilaiEkskul;

    public $listEkskul;
    public $idSiswa;
    public $idKelas;
    public $successMsg;
    public $errorMsg;

    public function mount()
    {
        $this->idKelas = request()->idKelas;
        $this->idSiswa = request()->idSiswa;
    }

    public function render()
    {
        $this->listEkskul = ModelsEkskul::where('idKelas', $this->idKelas)->where('idSiswa', $this->idSiswa)->get();
        return view('livewire.ekskul');
    }

    public function saveEkskul()
    {
        $this->successMsg = null;
        $this->errorMsg = null;
        $this->validate([
            'formNamaEkskul' => 'required|string',
            'formNilaiEkskul' => 'required|string',
        ], [
            'required' => 'Form Harus Di Isi'
        ]);

        try {
            ModelsEkskul::create([
                'idKelas' => $this->idKelas,
                'idSiswa' => $this->idSiswa,
                'namaEkskul' => $this->formNamaEkskul,
                'nilai' => $this->formNilaiEkskul
            ]);

            $this->formNamaEkskul = null;
            $this->formNilaiEkskul = null;
            $this->successMsg = "Tambah Ekskul Berhasil";
        } catch (\Throwable $th) {
            $this->errorMsg = "Tambah Ekskul Gagal";
        }
    }

    public function openModal($idEkskul, $namaEkskul)
    {
        $this->successMsg = null;
        $this->errorMsg = null;
        $this->isModalOpen = true;
        $this->ekskul = [
            "id" => $idEkskul,
            'namaEkskul' => $namaEkskul
        ];
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->ekskul = null;
    }

    public function deleteEkskul($idEkskul)
    {
        try {
            ModelsEkskul::where("idEkskul", $idEkskul)->delete();
            $this->isModalOpen = false;
            $this->successMsg = "Delete Ekskul Berhasil";
        } catch (\Throwable $th) {
            $this->successMsg = "Delete Ekskul Gagal";
        }
    }
}
