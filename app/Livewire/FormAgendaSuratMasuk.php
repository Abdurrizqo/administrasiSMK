<?php

namespace App\Livewire;

use App\Models\AgendaSurat;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class FormAgendaSuratMasuk extends Component
{
    use WithFileUploads;

    public $isModalOpen = false;

    #[Validate('required|string')]
    public $nomerSurat;

    #[Validate('required|string')]
    public $perihal;

    #[Validate('required|string')]
    public $tujaunSurat;

    #[Validate('required|file|mimes:pdf|max:10000')]
    public $dokumenSurat;

    #[Validate('required|date')]
    public $tanggalSurat;

    public function render()
    {
        return view('livewire.form-agenda-surat-masuk');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanAgendaSuratMasuk()
    {
        $validated = $this->validate();
        $filename = $this->dokumenSurat->store(path: 'dokumenSurat');

        $newAgenda = AgendaSurat::create([
            'tanggalAgenda' => date('Y-m-d'),
            'tanggalSurat' => $validated['tanggalSurat'],
            'statusSurat' => "MASUK",
            'nomerSurat' => $validated['nomerSurat'],
            'perihal' => $validated['perihal'],
            'asalTujuanSurat' => $validated['tujaunSurat'],
            'dokumenSurat' => $filename,
        ]);

        if ($newAgenda) {
            return redirect('dashboard/agenda-surat-masuk')->with('success', 'Surat Masuk Berhasil Dicatat');
        }
        return redirect('dashboard/agenda-surat-masuk')->with('error', 'Surat Masuk Gagal Dicatat');
    }
}
