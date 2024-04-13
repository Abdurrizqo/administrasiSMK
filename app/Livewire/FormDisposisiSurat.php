<?php

namespace App\Livewire;

use App\Models\DisposisiSurat;
use App\Models\Pegawai;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FormDisposisiSurat extends Component
{
    public $isModalOpen = false;
    public $pegawai = [];
    public $searchPegawai = '';

    #[Validate('required|string|exists:agenda_surat,idAgendaSurat')]
    public $idAgendaSurat;

    #[Validate('required|string')]
    public $arahan;

    #[Validate('required|string|max:120')]
    public $judulDisposisi;

    #[Validate('required|string|exists:pegawai,idPegawai')]
    public $tujuan;

    public $namaPegawai;
    public function mount($idAgendaSurat)
    {
        $this->idAgendaSurat = $idAgendaSurat;
    }

    public function render()
    {
        if ($this->searchPegawai) {
            $this->pegawai = Pegawai::where('namaPegawai', 'like', '%' . $this->searchPegawai . '%')->get();
        }


        return view('livewire.form-disposisi-surat');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanDisposisiSurat()
    {
        $validated = $this->validate();

        $newDisposisi = DisposisiSurat::create([
            'judulDisposisi' => $validated['judulDisposisi'],
            'idAgendaSurat' => $validated['idAgendaSurat'],
            'tanggalDisposisi' => date('Y-m-d'),
            'arahan' => $validated['arahan'],
            'tujuan' => $validated['tujuan'],
        ]);

        if ($newDisposisi) {
            return redirect('dashboard/agenda-surat-masuk')->with('success', 'Surat Berhasil Di Disposisikan');
        }
        return redirect('dashboard/agenda-surat-masuk')->with('error', 'Surat Gagal Di Disposisikan');
    }

    public function selectPegawai($idPegawai, $namaPegawai)
    {
        $this->tujuan = $idPegawai;
        $this->namaPegawai = $namaPegawai;
    }
}
