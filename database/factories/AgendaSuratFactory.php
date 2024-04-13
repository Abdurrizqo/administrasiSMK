<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgendaSurat>
 */
class AgendaSuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggalAgenda' => $this->faker->date,
            'tanggalSurat' => $this->faker->date,
            'statusSurat' => $this->faker->randomElement(['MASUK', 'KELUAR']),
            'nomerSurat' => $this->faker->word,
            'perihal' => $this->faker->paragraph(2),
            'asalTujuanSurat' => $this->faker->company,
            'dokumenSurat' => $this->faker->word,
            'hasDisposisi' => false,
        ];
    }
}
