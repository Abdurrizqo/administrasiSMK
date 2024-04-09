<?php

namespace App\Livewire;

use App\Models\KelasSiswa;
use App\Models\RekapPas;
use App\Models\RekapPts;
use Livewire\Component;

class InputNilai extends Component
{
    public $selectedSiswa = false;
    public $kelasSiswa;
    public $idKelas;
    public $idSiswa;
    public $semester;
    public $idKelasMapel;
    public $segmentSemester = "PTS";

    public $rekap;

    public $formNilaiAkademik;
    public $formNilaiKeterampilan;
    public $formKeterangan;

    public function mount($idKelas, $idKelasMapel, $semester)
    {
        $this->idKelas = $idKelas;
        $this->semester = $semester;
        $this->idKelasMapel = $idKelasMapel;
    }

    public function render()
    {
        $this->kelasSiswa = KelasSiswa::select(['namaSiswa', 'nis', 'nisn', 'kelas_siswa.idSiswa', 'idKelasSiswa'])
            ->where('idKelas', $this->idKelas)
            ->leftJoin('siswa', 'siswa.idSiswa', '=', 'kelas_siswa.idSiswa')
            ->get();

        return view('livewire.input-nilai');
    }

    public function save()
    {
        try {
            $terbilangAkademik = $this->terbilang($this->formNilaiAkademik);
            $terbilangKeterampilan = $this->terbilang($this->formNilaiKeterampilan);

            if ($this->segmentSemester === "PTS") {
                if ($this->rekap) {
                    RekapPts::where('kelas', $this->idKelas)
                        ->where('kelasMapel', $this->idKelasMapel)
                        ->where('siswa', $this->idSiswa)->update(
                            [
                                'nilaiAkademik' => $this->formNilaiAkademik,
                                'terbilangNilaiAkademik' => $terbilangAkademik,
                                'nilaiKeterampilan' => $this->formNilaiKeterampilan,
                                'terbilangNilaiKeterampilan' => $terbilangKeterampilan,
                                'keterangan' => $this->formKeterangan
                            ]
                        );
                } else {
                    RekapPts::create(
                        [
                            'kelasMapel' => $this->idKelasMapel,
                            'kelas' => $this->idKelas,
                            'siswa' => $this->idSiswa,
                            'semester' => $this->semester,
                            'nilaiAkademik' => $this->formNilaiAkademik,
                            'terbilangNilaiAkademik' => $terbilangAkademik,
                            'nilaiKeterampilan' => $this->formNilaiKeterampilan,
                            'terbilangNilaiKeterampilan' => $terbilangKeterampilan,
                            'keterangan' => $this->formKeterangan
                        ]
                    );
                }

                $this->rekap = RekapPts::where('kelas', $this->idKelas)
                    ->where('kelasMapel', $this->idKelasMapel)
                    ->where('siswa', $this->idSiswa)
                    ->first();
            } else {
                if ($this->rekap) {
                    RekapPas::where('kelas', $this->idKelas)
                        ->where('kelasMapel', $this->idKelasMapel)
                        ->where('siswa', $this->idSiswa)->update(
                            [
                                'nilaiAkademik' => $this->formNilaiAkademik,
                                'terbilangNilaiAkademik' => $terbilangAkademik,
                                'nilaiKeterampilan' => $this->formNilaiKeterampilan,
                                'terbilangNilaiKeterampilan' => $terbilangKeterampilan,
                                'keterangan' => $this->formKeterangan
                            ]
                        );
                } else {
                    RekapPas::create(
                        [
                            'kelasMapel' => $this->idKelasMapel,
                            'kelas' => $this->idKelas,
                            'siswa' => $this->idSiswa,
                            'semester' => $this->semester,
                            'nilaiAkademik' => $this->formNilaiAkademik,
                            'terbilangNilaiAkademik' => $terbilangAkademik,
                            'nilaiKeterampilan' => $this->formNilaiKeterampilan,
                            'terbilangNilaiKeterampilan' => $terbilangKeterampilan,
                            'keterangan' => $this->formKeterangan
                        ]
                    );
                }

                $this->rekap = RekapPas::where('kelas', $this->idKelas)
                    ->where('kelasMapel', $this->idKelasMapel)
                    ->where('siswa', $this->idSiswa)
                    ->first();
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function selectSiswa($idSiswa)
    {
        $this->formNilaiAkademik = null;
        $this->formNilaiKeterampilan = null;
        $this->formKeterangan = null;
        $this->idSiswa = null;

        if ($this->segmentSemester === "PTS") {
            $this->rekap = RekapPts::where('kelas', $this->idKelas)
                ->where('kelasMapel', $this->idKelasMapel)
                ->where('siswa', $idSiswa)
                ->first();
        } else {
            $this->rekap = RekapPas::where('kelas', $this->idKelas)
                ->where('kelasMapel', $this->idKelasMapel)
                ->where('siswa', $idSiswa)
                ->first();
        }

        $this->idSiswa = $idSiswa;

        $this->selectedSiswa = true;
    }

    public function resetView()
    {
        $this->formNilaiAkademik = null;
        $this->formNilaiKeterampilan = null;
        $this->formKeterangan = null;
        $this->idSiswa = null;
        $this->selectedSiswa = false;
    }

    private function terbilang($nilai)
    {
        $satuan = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh',
            'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas',
            'delapan belas', 'sembilan belas'
        ];
        $result = '';

        $nilai_bulat = floor($nilai);
        $nilai_desimal = round(($nilai - $nilai_bulat) * 100);

        if ($nilai_bulat < 20) {
            $result = $satuan[$nilai_bulat];
        } else if ($nilai_bulat < 100) {
            $valPuluh = floor($nilai_bulat / 10);
            $valSatuan = floor($nilai_bulat % 10);

            $result = "$satuan[$valPuluh] Puluh $satuan[$valSatuan]";
        } else if ($nilai_bulat == 100) {
            $result = 'seratus';
        }

        if ($nilai_desimal > 0) {
            $result .= ' koma ' . $satuan[floor($nilai_desimal / 10)] . ' ' . $satuan[$nilai_desimal % 10];
        }

        return $result;
    }
}
