<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Error;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function Laravel\Prompts\error;

class TambahSiswaKelas extends Component
{
    public $allSiswa;
    public $isLoadingSave = false;
    public $isLoadingDelete = false;
    public $isModalSaveOpen = false;
    public $isModalDeleteOpen = false;
    public $dataModal;
    public $idSiswa;
    public $idKelas;
    public $successMsg;
    public $errorMsg;
    public $searchDataSiswa = '';
    public $searchDataKelasSiswa = '';
    public $kelasSiswa;

    public function mount($idKelas = null)
    {
        $this->idKelas = $idKelas;
    }

    public function render()
    {
        if (empty($this->searchDataSiswa)) {
            $this->allSiswa = Siswa::select(['namaSiswa', 'idSiswa', 'nis', 'nisn', 'siswa.idJurusan', 'namaJurusan'])
                ->leftJoin('jurusan', 'jurusan.idJurusan', '=', 'siswa.idJurusan')
                ->take(10)
                ->orderBy('namaSiswa', 'asc')
                ->get();
        } else {
            $this->allSiswa = Siswa::select(['namaSiswa', 'idSiswa', 'nis', 'nisn', 'siswa.idJurusan', 'namaJurusan'])
                ->leftJoin('jurusan', 'jurusan.idJurusan', '=', 'siswa.idJurusan')
                ->where(function ($query) {
                    $query->where('namaSiswa', 'like', "%$this->searchDataSiswa%")
                        ->orWhere('nis', 'like', "%$this->searchDataSiswa%")
                        ->orWhere('nisn', 'like', "%$this->searchDataSiswa%");
                })
                ->take(10)
                ->orderBy('namaSiswa', 'asc')
                ->get();
        }

        if (empty($this->searchDataKelasSiswa)) {
            $this->kelasSiswa = KelasSiswa::select(['idKelas', 'idKelasSiswa', 'siswa.namaSiswa', 'nis', 'nisn', 'siswa.idJurusan'])
                ->where('idKelas', $this->idKelas)
                ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
                ->get();
        } else {
            $this->kelasSiswa = KelasSiswa::select(['idKelas', 'idKelasSiswa', 'siswa.namaSiswa', 'nis', 'nisn', 'siswa.idJurusan'])
                ->where('idKelas', $this->idKelas)
                ->where(function ($query) {
                    $query->where('namaSiswa', 'like', "%$this->searchDataKelasSiswa%")
                        ->orWhere('nis', 'like', "%$this->searchDataKelasSiswa%")
                        ->orWhere('nisn', 'like', "%$this->searchDataKelasSiswa%");
                })
                ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
                ->get();
        }

        return view('livewire.tambah-siswa-kelas');
    }

    public function masukanKelas($idSiswa)
    {
        DB::beginTransaction();
        try {
            $this->isLoadingSave = true;

            $kelas = Kelas::select(['tahunAjaran'])->where('idKelas', $this->idKelas)->first();
            $checkSiswa = KelasSiswa::where('idSiswa', $idSiswa)
                ->where('tahunAjaran', $kelas->tahunAjaran)
                ->leftJoin('kelas', 'kelas.idKelas', '=', 'kelas_siswa.idKelas')
                ->first();
            if ($checkSiswa) {
                throw new Error('Siswa Sudah Terdaftar Dalam Kelas');
            }

            KelasSiswa::create([
                'idKelas' => $this->idKelas,
                'idSiswa' => $idSiswa,
            ]);

            DB::commit();

            $this->successMsg = 'Siswa Berhasil Ditambahkan';
            $this->isModalSaveOpen = false;
            $this->dataModal = null;
            $this->isLoadingSave = false;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->errorMsg = $th->getMessage();
            $this->isModalSaveOpen = false;
            $this->dataModal = null;
            $this->isLoadingSave = false;
        }
    }

    public function openModalSave($namaSiswa, $idSiswa)
    {
        $this->dataModal = [
            'namaSiswa' => $namaSiswa,
            'idSiswa' => $idSiswa
        ];

        $this->isModalSaveOpen = true;
        $this->successMsg = null;
        $this->errorMsg = null;
    }

    public function closeModalSave()
    {
        $this->dataModal = null;
        $this->isModalSaveOpen = false;
    }

    public function openModalDelete($namaSiswa, $KelasSiswa)
    {
        $this->dataModal = [
            'namaSiswa' => $namaSiswa,
            'idKelasSiswa' => $KelasSiswa
        ];

        $this->successMsg = null;
        $this->errorMsg = null;
        $this->isModalDeleteOpen = true;
    }

    public function closeModalDelete()
    {
        $this->dataModal = null;
        $this->isModalDeleteOpen = false;
    }

    public function deleteSiswa($idKelasSiswa)
    {
        DB::beginTransaction();
        try {
            $check =  KelasSiswa::where('idKelasSiswa', $idKelasSiswa)->delete();

            if (!$check) {
                throw new Error('Hapus Data Siswa Gagal');
            }

            DB::commit();
            $this->successMsg = 'Hapus Data Siswa Berhasil';
            $this->dataModal = null;
            $this->isModalDeleteOpen = false;
        } catch (\Throwable $th) {
            $this->errorMsg = $th->getMessage();
            $this->isModalDeleteOpen = false;
            $this->dataModal = null;
            DB::rollBack();
        }
    }
}
