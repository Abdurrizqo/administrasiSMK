<?php

use App\Events\HelloEvent;
use App\Http\Controllers\AgendaSuratController;
use App\Http\Controllers\CatatanPegawaiControlller;
use App\Http\Controllers\CatatanSiswaController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\JurnalKegiatanController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\RencanaKegiatanController;
use App\Http\Controllers\SertifikatPegawaiControlller;
use App\Http\Controllers\SertifikatSiswaControlller;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Models\Pegawai;
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

Route::get('/', [UserController::class, 'loginView'])->middleware('guestcheck');
Route::post('/', [UserController::class, 'loginUser'])->middleware('guestcheck');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/download-file/message/{filename}', [MessageController::class, 'downloadFileOnMessage'])->name('messageFile.download');
    Route::get('/download-file/surat/{filename}', [AgendaSuratController::class, 'downloadFileOnDokumen'])->name('dokumenFile.download');
    Route::get('/load-message/{idDisposisi}', [MessageController::class, 'loadMessage']);
    Route::post('/send-message/{idDisposisi}', [MessageController::class, 'saveMessage']);

    Route::get("/ganti-photo-profile", [PegawaiController::class, 'gantiPhotoProfileView']);
    Route::post("/ganti-photo-profile", [PegawaiController::class, 'gantiPhotoProfile']);

    Route::get("/ganti-photo-profile-guru", [PegawaiController::class, 'gantiPhotoProfileGuruView']);
    Route::post("/ganti-photo-profile-guru", [PegawaiController::class, 'gantiPhotoProfileGuru']);

    Route::get("/list-pegawai", [PegawaiController::class, 'getAllPegawawi']);

    Route::get('/rencana-kegiatan', [RencanaKegiatanController::class, 'index']);
    Route::get('/rencana-kegiatan/create', [RencanaKegiatanController::class, 'storeView']);
    Route::post('/rencana-kegiatan/create', [RencanaKegiatanController::class, 'store']);
    Route::get('/rencana-kegiatan/detail/{idRencanaKegiatan}', [RencanaKegiatanController::class, 'show']);
    Route::post('/rencana-kegiatan/detail/{idRencanaKegiatan}', [RencanaKegiatanController::class, 'update']);


    Route::middleware(['guru.role'])->group(function () {
        Route::get('/home', [PegawaiController::class, 'homePegawaiView']);
        Route::get('/home/ganti-password', [PegawaiController::class, 'GantiPasswordView']);
        Route::post('/home/ganti-password', [PegawaiController::class, 'handleGantiPassword']);

        Route::get('/home/rekap-nilai-kelas', [RekapNilaiController::class, 'rekapNilaiKelasExcel']);

        Route::get('/home/siswa/{idKelas}/{idSiswa}', [RekapNilaiController::class, 'rekapNilaiPerSiswa']);
        Route::post('/home/siswa/{idKelas}/{idSiswa}', [RekapNilaiController::class, 'setKenaikanKelas']);
        Route::get('/home/siswa/{idKelas}/{idSiswa}/raportpdf', [RekapNilaiController::class, 'cetakRaportSiswa']);
        Route::get('/home/siswa/{idKelas}/{idSiswa}/rekap-nilai-siswa', [RekapNilaiController::class, 'rekapNilaiSiswaExcel']);
        Route::post('catatan/{idSiswa}', [CatatanSiswaController::class, 'createCatatanSiswaByGuru']);
        Route::post('sertifikat/{idSiswa}', [SertifikatSiswaControlller::class, 'addSertifikatSiswa']);
        Route::get('catatan/{idCatatanSiswa}/delete', [CatatanSiswaController::class, 'deleteCatatanSiswa']);
        Route::get('sertifikat/{idSertifikatSiswa}/delete', [SertifikatSiswaControlller::class, 'deleteSertifikatSiswa']);

        Route::get('/home/disposisi/{idDisposisi}', [DisposisiController::class, 'balasanDisposisi']);

        Route::get('/home/kelas/{idKelasMapel}', [RekapNilaiController::class, 'kelasSiswaView']);
    });

    Route::middleware(['tu.role'])->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'getProfile']);
        Route::get('/dashboard/ganti-password', [PegawaiController::class, 'GantiPasswordTUView']);
        Route::post('/dashboard/ganti-password', [PegawaiController::class, 'handleGantiPassword']);

        Route::post('/dashboard/tambah-logo', [ProfileController::class, 'addLogo']);
        Route::get('/dashboard/edit-profile-sekolah', [ProfileController::class, 'editProfileView']);
        Route::get('/dashboard/edit-profile-tambahan', [ProfileController::class, 'editProfileTambahanView']);
        Route::get('/dashboard/edit-visi-misi', [ProfileController::class, 'editVisiMisiView']);
        Route::post('/dashboard/edit-profile-sekolah', [ProfileController::class, 'handleEditProfile']);
        Route::post('/dashboard/edit-profile-tambahan', [ProfileController::class, 'handleEditProfileTambahan']);
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
        Route::get('/dashboard/pegawai/delete/{nip}', [PegawaiController::class, 'deletePegawai']);
        Route::get('/dashboard/pegawai/{idPegawai}', [PegawaiController::class, 'detailPegawai']);
        Route::post('/dashboard/pegawai/{idPegawai}', [CatatanPegawaiControlller::class, 'createCatatanPegawai'])->name('addCatatanSiswa');
        Route::post('/dashboard/pegawai/{idPegawai}/sertifikat', [SertifikatPegawaiControlller::class, 'addSertifikatPegawai'])->name('addSertifikatPegawai');
        Route::get('/dashboard/pegawai/{idCatatanSiswa}/delete/catatan', [CatatanPegawaiControlller::class, 'deleteCatatanPegawai'])->name('deleteSertifikatPegawai');
        Route::get('/dashboard/pegawai/{idSertifikatSiswa}/delete/sertifikat', [SertifikatPegawaiControlller::class, 'deleteSertifikatPegawai'])->name('deleteSertifikatPegawai');

        Route::get('/dashboard/siswa', [SiswaController::class, 'listSiswa']);
        Route::get('/dashboard/siswa/tambah-siswa', [SiswaController::class, 'addSiswaView']);
        Route::post('/dashboard/siswa/tambah-siswa', [SiswaController::class, 'handleAddSiswa']);
        Route::get('/dashboard/siswa/import-excel-siswa', [SiswaController::class, 'imporSiswaFromExcelView']);
        Route::post('/dashboard/siswa/import-excel-siswa', [SiswaController::class, 'handleImporSiswaFromExcel']);
        Route::get('/dashboard/siswa/detail/{idSiswa}', [SiswaController::class, 'detailSiswa'])->name('detailSiswa');
        Route::post('/dashboard/siswa/detail/{idSiswa}', [CatatanSiswaController::class, 'createCatatanSiswa']);
        Route::get('/dashboard/siswa/detail/{idSiswa}/raport/{idKelas}', [SiswaController::class, 'detailRaportSiswa'])->name('siswa.raport');
        Route::get('/dashboard/siswa/detail/{idSiswa}/edit', [SiswaController::class, 'editSiswaView']);
        Route::post('/dashboard/siswa/detail/{idSiswa}/edit', [SiswaController::class, 'handleEditSiswa']);
        Route::get('/dashboard/siswa/raport/download/{filename}', [SiswaController::class, 'downloadRaport'])->name('siswa.downloadRaport');
        Route::post('/dashboard/siswa/{idSiswa}/add-foto', [SiswaController::class, 'addFotoSiswa']);
        Route::post('/dashboard/siswa/{idSiswa}/ganti-status', [SiswaController::class, 'gantiStatusSiswa']);
        Route::get('/dashboard/siswa/ijazah/download/{filename}', [SiswaController::class, 'downloadIjazah'])->name('siswa.downloadIjazah');
        Route::post('/dashboard/siswa/detail/{idSiswa}/sertifikat', [SertifikatSiswaControlller::class, 'addSertifikatSiswa'])->name('addSertifikatSiswa');
        Route::get('/dashboard/siswa/{idSertifikatSiswa}/delete/sertifikat', [SertifikatSiswaControlller::class, 'deleteSertifikatSiswa'])->name('deleteSertifikatSiswa');
        Route::get('/dashboard/siswa/{idCatatanSiswa}/delete/catatan', [CatatanSiswaController::class, 'deleteCatatanSiswa'])->name('deleteSertifikatSiswa');

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

        Route::get('/dashboard/jurnal-kegiatan', [JurnalKegiatanController::class, 'index']);
        Route::get('/dashboard/jurnal-kegiatan/tulis-jurnal', [JurnalKegiatanController::class, 'storeView']);
        Route::post('/dashboard/jurnal-kegiatan/tulis-jurnal', [JurnalKegiatanController::class, 'store']);
        Route::get('/dashboard/jurnal-kegiatan/export-jurnal', [JurnalKegiatanController::class, 'exportJurnal']);
    });
});
