<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\MessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function loadMessage($idDisposisi)
    {
        try {
            $loadChat = MessageModel::where('idDisposisi', $idDisposisi)->get();
            return response()->json(['data' => $loadChat], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to Load message'], 500);
        }
    }

    public function downloadFileOnMessage($filename)
    {
        $path = storage_path('app/fileMessage/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404, 'File not found');
        }
    }
}
