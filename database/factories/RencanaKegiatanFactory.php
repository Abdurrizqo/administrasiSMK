<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RencanaKegiatan>
 */
class RencanaKegiatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idRencanaKegiatan' => $this->faker->uuid,
            'tanggalMulaiKegiatan' => $this->faker->date,
            'namaKegiatan' => $this->faker->sentence(8),
            'ketuaPelaksana' => Pegawai::inRandomOrder()->first()->idPegawai,
            'wakilKetuaPelaksana' => Pegawai::inRandomOrder()->first()->namaPegawai,
            'sekretaris' => Pegawai::inRandomOrder()->first()->namaPegawai,
            'bendahara' => Pegawai::inRandomOrder()->first()->namaPegawai,
            'dokumenProposal' => $this->faker->word . '.pdf',
            'isFinish' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
