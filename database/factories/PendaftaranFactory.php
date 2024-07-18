<?php

namespace Database\Factories;

use App\Models\Pendaftaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PendaftaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $pendaftaran = Pendaftaran::class;
    public function definition(): array
    {
        return [
            'nik_id' => $this->faker->numberBetween(1, 5),
            'lowongan_id' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([
                'DITERIMA',
                'DITOLAK',
                'INTERVIEW',
                'TERDAFTAR',
                'LOLOS BERKAS',
            ]),
            'tanggal_interview' => $this->faker->dateTimeBetween('now', '2024-12-31 23:59:59')->format('Y-m-d H:i:s'),

        ];
    }
}
