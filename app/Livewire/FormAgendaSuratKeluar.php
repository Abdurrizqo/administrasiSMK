<?php

namespace App\Livewire;

use App\Models\AgendaSurat;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormAgendaSuratKeluar extends Component
{
    use WithFileUploads;

    public $isModalOpen = false;

    #[Validate('required|string')]
    public $nomerSurat;

    #[Validate('required|string')]
    public $perihal;

    #[Validate('required|string')]
    public $asalSurat;

    #[Validate('required|file|mimes:pdf|max:10000')]
    public $dokumenSurat;

    #[Validate('required|date')]
    public $tanggalSurat;

    public function render()
    {
        return view('livewire.form-agenda-surat-keluar');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanAgendaSuratKeluar()
    {
        $validated = $this->validate();
        $filename = $this->dokumenSurat->store(path: 'dokumenSurat');

        $newAgenda = AgendaSurat::create([
            'tanggalAgenda' => date('Y-m-d'),
            'tanggalSurat' => $validated['tanggalSurat'],
            'statusSurat' => "KELUAR",
            'nomerSurat' => $validated['nomerSurat'],
            'perihal' => $validated['perihal'],
            'asalTujuanSurat' => $validated['asalSurat'],
            'dokumenSurat' => $filename,
        ]);

        if ($newAgenda) {
            return redirect('dashboard/agenda-surat-keluar')->with('success', 'Surat Keluar Berhasil Dicatat');
        }
        return redirect('dashboard/agenda-surat-keluar')->with('error', 'Surat Keluar Gagal Dicatat');
    }
}
