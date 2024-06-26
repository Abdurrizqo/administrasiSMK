<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AgendaSurat;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Pegawai;
use App\Models\PelengkapSekolah;
use App\Models\ProfilSekolah;
use App\Models\RencanaKegiatan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        ProfilSekolah::create([
            'namaSekolah' => 'SMK Muhammadiyah 1 Sangatta Utara',
            'npsn' => fake()->unique()->numerify('##########'),
            'nss' => fake()->unique()->numerify('##########'),
            'namaKepalaSekolah' => 'Abdurrizqo Arrahman',
            'nipKepalaSekolah' => fake()->unique()->numerify('##########'),
            'alamat' => 'Jl. H. Ahmad Dahlan',
            'tahunBerdiri' => '1990',
            'tahunAjaran' => '2023/2024',
            'semester' => 'GENAP',
            'jenjangPendidikan' => 'SMK',
            'lintang' => '0.4989',
            'bujur' => '117.5415',
            'email' => 'abdurrizqoarra@gmail.com',
            'website' => 'abdurrizqo.com',
            'nomerTelfon' => '081380091948',
        ]);

        PelengkapSekolah::create(
            [
                'skPendirian' => '0912841',
                'tanggalSk' => fake()->dateTimeThisDecade(),
                'skIzin' => '0912841',
                'tanggalSkIzin' => fake()->dateTimeThisDecade(),
                'rekening' => '0912841',
                'noRekening' => '0912841',
                'atasNamaRekening' => '0912841',
            ]
        );

        $dataPegawai = Pegawai::create([
            'nipy' => '019374719',
            'namaPegawai' => 'Pegawai Admin Simulasi',
            'status' => 'TU',
        ]);

        $dataUser = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => "TU",
            'idPegawai' => $dataPegawai['idPegawai'],
        ]);

        Pegawai::where('idPegawai', $dataPegawai['idPegawai'])->update(['idUser' => $dataUser['idUser']]);

        Pegawai::factory()->count(100)->create();

        Jurusan::insert([
            [
                'idJurusan' => Uuid::uuid4(),
                'namaJurusan' => 'Teknik Kendaraan Ringan'
            ],
            [
                'idJurusan' => Uuid::uuid4(),
                'namaJurusan' => 'Teknologi Komunikasi Jaringan'
            ],
            [
                'idJurusan' => Uuid::uuid4(),
                'namaJurusan' => 'Rekayasa Perangkat Lunak'
            ],
            [
                'idJurusan' => Uuid::uuid4(),
                'namaJurusan' => 'Teknik Elektro'
            ],
        ]);

        MataPelajaran::insert([
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Matematika'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Dasar Pemrograman'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Dasar Komunikasi Jaringan'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Pendidikan Kewarganegaraan'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Bahasa Indonesia'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Bahasa Inggris'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Bahasa Arab'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Biologi'
            ],
            [
                'idMataPelajaran' => Uuid::uuid4(),
                'namaMataPelajaran' => 'Kebudayaan'
            ],
        ]);

        Siswa::factory()->count(600)->create();
        AgendaSurat::factory()->count(1000)->create();
        RencanaKegiatan::factory()->count(1000)->create();
    }
}
