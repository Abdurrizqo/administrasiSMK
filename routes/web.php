<?php

use App\Events\HelloEvent;
use App\Http\Controllers\AgendaSuratController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'loginView']);
Route::post('/', [UserController::class, 'loginUser']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/tes', function () {
    return view('pdf.raport');
});

Route::get('/home', [PegawaiController::class, 'homePegawaiView']);
Route::get('/home/rekap-nilai-kelas', [RekapNilaiController::class, 'rekapNilaiKelasExcel']);
Route::get('/download-file/message/{filename}', [MessageController::class, 'downloadFileOnMessage'])->name('messageFile.download');
Route::get('/download-file/surat/{filename}', [AgendaSuratController::class, 'downloadFileOnDokumen'])->name('dokumenFile.download');

Route::get('/home/siswa/{idKelas}/{idSiswa}', [RekapNilaiController::class, 'rekapNilaiPerSiswa']);
Route::post('/home/siswa/{idKelas}/{idSiswa}', [RekapNilaiController::class, 'setKenaikanKelas']);
Route::get('/home/siswa/{idKelas}/{idSiswa}/raportpdf', [RekapNilaiController::class, 'cetakRaportSiswa']);
Route::get('/home/siswa/{idKelas}/{idSiswa}/rekap-nilai-siswa', [RekapNilaiController::class, 'rekapNilaiSiswaExcel']);
Route::get('/home/disposisi/{idDisposisi}', [DisposisiController::class, 'balasanDisposisi']);

Route::get('/home/kelas/{idKelasMapel}', [RekapNilaiController::class, 'kelasSiswaView']);

Route::get('/dashboard', [ProfileController::class, 'getProfile']);
Route::post('/dashboard/tambah-logo', [ProfileController::class, 'addLogo']);
Route::get('/dashboard/edit-profile-sekolah', [ProfileController::class, 'editProfileView']);
Route::post('/dashboard/edit-profile-sekolah', [ProfileController::class, 'handleEditProfile']);
Route::get('/dashboard/atur-akreditas-sekolah', [ProfileController::class, 'aturAkreditasSekolah']);
Route::post('/dashboard/atur-akreditas-sekolah', [ProfileController::class, 'handleAturAkreditasSekolah']);

Route::get('/dashboard/jurusan', [JurusanController::class, 'listJurusan']);
Route::post('/dashboard/jurusan', [JurusanController::class, 'addJurusan']);
Route::post('/dashboard/jurusan/edit', [JurusanController::class, 'editJurusan']);
Route::get('/dashboard/jurusan/non-aktif/{idJurusan}', [JurusanController::class, 'ubahStatusJurusan']);

Route::get('/dashboard/mapel', [MapelController::class, 'listMapel']);
Route::post('/dashboard/mapel', [MapelController::class, 'addMapel']);
Route::post('/dashboard/mapel/edit', [MapelController::class, 'editMapel']);

Route::get('/dashboard/pegawai', [PegawaiController::class, 'listPegawai']);
Route::get('/dashboard/pegawai/tambah-pegawai', [PegawaiController::class, 'addPegawaiView']);
Route::post('/dashboard/pegawai/tambah-pegawai', [PegawaiController::class, 'handleAddPegawai']);
Route::post('/dashboard/pegawai/tambah-user', [PegawaiController::class, 'addUserPegawai']);
Route::get('/dashboard/pegawai/edit/{nip}', [PegawaiController::class, 'editPegawaiView']);
Route::post('/dashboard/pegawai/edit/{nip}', [PegawaiController::class, 'handleEditPegawai']);

Route::get('/dashboard/siswa', [SiswaController::class, 'listSiswa']);
Route::get('/dashboard/siswa/tambah-siswa', [SiswaController::class, 'addSiswaView']);
Route::post('/dashboard/siswa/tambah-siswa', [SiswaController::class, 'handleAddSiswa']);
Route::get('/dashboard/siswa/detail/{idSiswa}', [SiswaController::class, 'detailSiswa'])->name('detailSiswa');
Route::get('/dashboard/siswa/detail/{idSiswa}/raport/{idKelas}', [SiswaController::class, 'detailRaportSiswa']);
Route::get('/dashboard/siswa/detail/{idSiswa}/edit', [SiswaController::class, 'editSiswaView']);
Route::post('/dashboard/siswa/detail/{idSiswa}/edit', [SiswaController::class, 'handleEditSiswa']);

Route::get('/dashboard/kelas', [KelasController::class, 'listKelas']);
Route::post('/dashboard/kelas', [KelasController::class, 'handleAddKelas']);
Route::get('/dashboard/kelas/detail/{idKelas}/ganjil', [KelasController::class, 'detailKelas']);
Route::get('/dashboard/kelas/detail/{idKelas}/genap', [KelasController::class, 'detailKelas']);
Route::get('/dashboard/kelas/detail/{idKelas}/tambah-siswa', [KelasController::class, 'tambahSiswaKelas']);
Route::post('/dashboard/kelas/edit', [KelasController::class, 'handleEditKelas']);
Route::get('/dashboard/kelas/delete/{idKelas}', [KelasController::class, 'deleteKelas']);

Route::get('/dashboard/agenda-surat-masuk', [AgendaSuratController::class, 'getAllAgendaSuratMasuk']);
Route::get('/dashboard/agenda-surat-masuk/export', [AgendaSuratController::class, 'exportSuratMasuk']);
Route::get('/dashboard/agenda-surat-keluar', [AgendaSuratController::class, 'getAllAgendaSuratKeluar']);
Route::get('/dashboard/agenda-surat-keluar/export', [AgendaSuratController::class, 'exportSuratKeluar']);

Route::get('/dashboard/disposisi-surat', [DisposisiController::class, 'listDisposisiSurat']);
Route::get('/dashboard/disposisi-surat/{idDisposisi}', [DisposisiController::class, 'balasanDisposisi']);
Route::get('/load-message/{idDisposisi}', [MessageController::class, 'loadMessage']);
Route::post('/send-message/{idDisposisi}', [MessageController::class, 'saveMessage']);
