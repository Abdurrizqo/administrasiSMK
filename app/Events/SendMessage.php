<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $disposisiSurat;
    public $pegawai;
    public $message;
    public $file;

    public function __construct( $disposisiSurat, $pegawai, $message, $file)
    {
        $this->disposisiSurat = $disposisiSurat;
        $this->pegawai = $pegawai;
        $this->message = $message;
        $this->file = $file;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->disposisiSurat),
        ];
    }
}
