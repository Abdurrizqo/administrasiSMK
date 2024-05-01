<?php

namespace App\Livewire;

use App\Models\VisiMisi;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Misi extends Component
{
    #[Validate('required|string')]
    public $konten;

    #[Validate('nullable|string|exists:visi_misi,idVisiMisi')]
    public $idMisi;

    public $idDeleteMisi;

    public $misi;

    public $isModalOpen = false;

    public function render()
    {
        $this->misi = VisiMisi::where('visiMisi', 'Misi')->orderBy('created_at', 'asc')->get();
        return view('livewire.misi');
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            if ($this->idMisi) {
                VisiMisi::where("idVisiMisi", $this->idMisi)->update(['konten' => $this->konten]);
            } else {
                VisiMisi::create(
                    [
                        'konten' => $validated['konten'],
                        'visiMisi' => "Misi"
                    ]
                );
            }

            $this->konten = '';
            $this->idMisi = '';
        } catch (\Throwable $th) {
            return redirect()->to('/dashboard/edit-visi-misi')->with(['error' => 'Delete Misi Gagal ' . $th->getMessage()]);
        }
    }

    public function edit($id, $konten)
    {
        $this->idMisi = $id;
        $this->konten = $konten;
    }

    public function cancelEdit()
    {
        $this->idMisi = '';
        $this->konten = '';
    }

    public function openModal($id)
    {
        $this->isModalOpen = true;
        $this->idDeleteMisi = $id;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->idDeleteMisi = '';
    }

    public function deleteMisi()
    {
        try {
            VisiMisi::where('idVisiMisi', $this->idDeleteMisi)->delete();

            $this->idDeleteMisi = '';
            return redirect()->to('/dashboard/edit-visi-misi')->with(['success' => 'Delete Misi Berhasil']);
        } catch (\Throwable $th) {
            $this->idDeleteMisi = '';
            return redirect()->to('/dashboard/edit-visi-misi')->with(['error' => 'Delete Misi Gagal ' . $th->getMessage()]);
        }
    }
}
