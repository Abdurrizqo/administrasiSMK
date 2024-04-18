<?php

use App\Models\DisposisiSurat;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat.{disposisiSurat}', function ($user, $disposisiSurat) {
    $check = DisposisiSurat::where('idDisposisi', $disposisiSurat)->where('tujuan', $user->idPegawai)->first();
    if ($user->role === "TU" || $check) {
        return true;
    }
    return false;
});
