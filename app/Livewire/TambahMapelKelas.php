<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\MataPelajaran;
use App\Models\Pegawai;
use Livewire\Component;

class TambahMapelKelas extends Component
{
    public $guru;
    public $mapel;
    public $listKelasMapel;
    public $kelas;
    public $semester;
    public $modalIsOpenDelete = false;
    public $modalIsOpenEdit = false;
    public $dataModal = null;
    public $messageSuccess = null;
    public $messageError = null;

    public $stateGuru;
    public $stateMapel;

    public $stateGuruEdit;
    public $stateMapelEdit;

    public $idKelas;

    public function mount($idKelas = null, $semester = null)
    {
        $this->idKelas = $idKelas;

        $this->semester = $semester;
    }

    public function render()
    {
        $this->kelas = Kelas::select(['tahunAjaran', 'idKelas', 'namaKelas', 'pegawai.namaPegawai'])->where('idKelas', $this->idKelas)->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas.waliKelas')->first();

        $this->guru = Pegawai::where('isActive', true)->where('status', 'GURU')->orderBy('namaPegawai', 'asc')->get();

        $this->mapel = MataPelajaran::orderBy('namaMataPelajaran', 'asc')
            ->get();

        $this->listKelasMapel = KelasMapel::select(['idKelasMapel', 'idPegawai', 'idMataPelajaran', 'namaPegawai', 'namaMataPelajaran'])->where('kelas', $this->idKelas)->where('semester', $this->semester)
            ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas_mapel.guruMapel')
            ->leftjoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
            ->orderBy('namaMataPelajaran', 'asc')
            ->get();

        return view('livewire.tambah-mapel-kelas');
    }

    public function save()
    {
        $this->messageSuccess  = null;
        $this->messageError = null;

        try {
            KelasMapel::create([
                'kelas' => $this->idKelas,
                'guruMapel' => $this->stateGuru,
                'mapel' => $this->stateMapel,
                'semester' => $this->semester,
            ]);

            $this->messageSuccess = 'Tambah Mapel Berhasil';
            $this->stateGuru = null;
            $this->stateMapel = null;
        } catch (\Throwable $th) {
            $this->messageError = 'Tambah Mapel Gagal';
            $this->stateGuru = null;
            $this->stateMapel = null;
        }
    }

    public function openModal($namaMapel, $idMapel)
    {
        $this->messageSuccess  = null;
        $this->messageError = null;

        $this->dataModal = [
            'namaMapel' => $namaMapel,
            'idMapel' => $idMapel,
        ];

        $this->modalIsOpenDelete = true;
    }

    public function closeModal()
    {
        $this->messageSuccess  = null;
        $this->messageError = null;
        $this->dataModal = null;
        $this->modalIsOpenDelete = false;
    }

    public function openModalEdit($mataPelajaran, $idPegawai, $idKelasMapel, $namaMapel)
    {
        $this->messageSuccess  = null;
        $this->messageError = null;
        $this->stateGuruEdit = $idPegawai;
        $this->stateMapelEdit = $mataPelajaran;

        $this->dataModal = [
            'idKelasMapel' => $idKelasMapel,
            'namaMapel' => $namaMapel,
            'idPegawai' => $idPegawai,
            'idMataPelajaran' => $mataPelajaran,
        ];

        $this->modalIsOpenEdit = true;
    }

    public function closeModalEdit()
    {
        $this->messageSuccess  = null;
        $this->messageError = null;
        $this->dataModal = null;
        $this->modalIsOpenEdit = false;
    }

    public function delete($idKelasMapel)
    {
        $this->messageSuccess  = null;
        $this->messageError = null;

        $kelasMapel = KelasMapel::where('idKelasMapel', $idKelasMapel)->delete();

        if ($kelasMapel) {
            $this->listKelasMapel = KelasMapel::select(['idKelasMapel', 'idPegawai', 'idMataPelajaran', 'namaPegawai', 'namaMataPelajaran'])
                ->where('kelas', $this->idKelas)
                ->leftJoin('pegawai', 'pegawai.idPegawai', '=', 'kelas_mapel.guruMapel')
                ->leftjoin('mata_pelajaran', 'mata_pelajaran.idMataPelajaran', '=', 'kelas_mapel.mapel')
                ->get();

            $this->messageSuccess = 'Data Mapel Berhasil Dihapus';
            $this->dataModal = null;
            $this->modalIsOpenDelete = false;
        } else {
            $this->messageError = 'Data Mapel Gagal';
            $this->dataModal = null;
        }
    }

    public function edit($idKelasMapel)
    {
        $this->messageSuccess  = null;
        $this->messageError = null;

        try {
            KelasMapel::where('idKelasMapel', $idKelasMapel)->update([
                'kelas' => $this->idKelas,
                'guruMapel' => $this->stateGuruEdit,
                'mapel' => $this->stateMapelEdit,
                'semester' => $this->semester,
            ]);

            $this->messageSuccess = 'Edit Data Mapel Berhasil';
            $this->dataModal = null;
            $this->modalIsOpenEdit = false;
            $this->stateGuruEdit = null;
            $this->stateMapelEdit = null;
        } catch (\Throwable $th) {
            $this->messageError = 'Edit Data Mapel Gagal';
            $this->dataModal = null;
            $this->modalIsOpenEdit = false;
            $this->stateGuruEdit = null;
            $this->stateMapelEdit = null;
        }
    }
}
