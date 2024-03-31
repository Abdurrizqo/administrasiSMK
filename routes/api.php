<?php

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/rekap-pts/{idRekapPts}', [RekapNilaiController::class, 'handleInputRekapPTS']);
Route::post('/rekap-pas/{idRekapPas}', [RekapNilaiController::class, 'handleInputRekapPAS']);
