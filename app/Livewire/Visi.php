<?php

namespace App\Livewire;

use App\Models\VisiMisi;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Visi extends Component
{
    #[Validate('required|string')]
    public $konten;

    public $visi;


    public function render()
    {
        $this->visi = VisiMisi::where('visiMisi', 'Visi')->first();
        return view('livewire.visi');
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            if ($this->visi) {
                $this->visi->konten = $validated['konten'];
                $this->visi->save();
            } else {
                VisiMisi::create([
                    'konten' => $validated['konten'],
                    'visiMisi' => "Visi"
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->to('/dashboard/edit-visi-misi')->with(['error' => 'Simpan Visi Gagal ' . $th->getMessage()]);
        }
    }
}
