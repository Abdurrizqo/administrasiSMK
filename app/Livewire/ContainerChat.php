<?php

namespace App\Livewire;

use App\Events\SendMessage;
use App\Models\MessageModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ContainerChat extends Component
{
    use WithFileUploads;

    #[Validate('max:10000')]
    public $dataFile;

    public $idDisposisi;
    public $message;



    public function mount($idDisposisi)
    {
        $this->idDisposisi = $idDisposisi;
    }

    public function render()
    {
        return view('livewire.container-chat');
    }

    public function saveMessage()
    {
        $this->validate();

        $user = Auth::user();

        $fileName = null;
        if ($this->dataFile) {
            $fileName = $this->dataFile->store(path: 'fileMessage');
        }

        MessageModel::create([
            'message' => $this->message,
            'idDisposisi' => $this->idDisposisi,
            'pegawai' => $user->idPegawai,
            'file' => $fileName
        ]);
        
        broadcast(new SendMessage($this->idDisposisi, $user, $this->message, $fileName));
        
        $this->message = '';
        $this->dataFile = null;
    }

    public function removeImage()
    {
        $this->dataFile = null;
    }
}
