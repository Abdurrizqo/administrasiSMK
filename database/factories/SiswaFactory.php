<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numerify('##########'),
            'nisn' => fake()->unique()->numerify('##########'),
            'namaSiswa' => fake()->name(),
            'tahunMasuk' => '2012',
            'idJurusan' => Jurusan::inRandomOrder()->first()->idJurusan,
            'status' => 'aktif',
            'nikWali' => fake()->unique()->numerify('##########'),
            'namaWali' => fake()->name(),
            'hubunganKeluarga' => 'Ayah',
            'alamat' => fake()->address(),
        ];
    }
}
