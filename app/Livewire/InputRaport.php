<?php

namespace App\Livewire;

use App\Models\KelasSiswa;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InputRaport extends Component
{
    use WithFileUploads;

    public $isModalOpen = false;
    public $semester;
    public $idKelas;
    public $idSiswa;

    #[Validate('required|file|mimes:pdf|max:10000')]
    public $dokumenRaport;

    public function mount($semester, $idKelas, $idSiswa)
    {
        $this->semester = $semester;
        $this->idKelas = $idKelas;
        $this->idSiswa = $idSiswa;
    }

    public function render()
    {
        return view('livewire.input-raport');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanDokumenRaport()
    {
        $this->validate();

        if ($this->semester === "GANJIL") {
            $querySelect = ['raportGanjil as dokumenRaport'];
        } else {
            $querySelect = ['raportGenap as dokumenRaport'];
        }

        $kelasSiswa = KelasSiswa::select($querySelect)->where("idKelas", $this->idKelas)
            ->where("idSiswa", $this->idSiswa)
            ->first();

        if ($kelasSiswa->dokumenRaport) {
            if (file_exists(storage_path('app/' . $kelasSiswa->dokumenRaport))) {
                unlink(storage_path('app/' . $kelasSiswa->dokumenRaport));
            }
        }

        $filename = $this->dokumenRaport->store(path: 'dokumenRaport');

        if ($this->semester === "GANJIL") {
            $check = KelasSiswa::where("idKelas", $this->idKelas)
                ->where("idSiswa", $this->idSiswa)
                ->update(['raportGanjil' => $filename]);
        } else {
            $check = KelasSiswa::where("idKelas", $this->idKelas)
                ->where("idSiswa", $this->idSiswa)
                ->update(['raportGenap' => $filename]);
        }

        if ($check) {
            return redirect()->route('siswa.raport', ['idSiswa' => $this->idSiswa, 'idKelas' => $this->idKelas])->with('success', 'Simpan Dokumen Raport Berhasil');
        } else {
            if ($kelasSiswa->dokumenRaport) {
                if (file_exists(storage_path('app/' . $kelasSiswa->dokumenRaport))) {
                    unlink(storage_path('app/' . $kelasSiswa->dokumenRaport));
                }
            }
            return redirect()->route('siswa.raport', ['idSiswa' => $this->idSiswa, 'idKelas' => $this->idKelas])->with('error', 'Simpan Dokumen Raport Gagal');
        }
    }
}
