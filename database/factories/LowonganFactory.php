<?php

namespace Database\Factories;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LowonganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $lowongan = Lowongan::class;
    public function definition(): array
    {
        $divisi = $this->faker->randomElement(['IT', 'HR', 'Marketing', 'Finance', 'Operations']);

        $jobdesk = [
            'IT' => [
                'melakukan maintenance server',
                'mengawasi metrik log server',
                'memastikan keamanan jaringan',
                'memonitor performa aplikasi',
                'mengelola backup data',
            ],
            'HR' => [
                'mengelola rekrutmen dan seleksi karyawan',
                'mengembangkan program pelatihan karyawan',
                'mengelola administrasi kepegawaian',
                'menyusun kebijakan dan prosedur HR',
                'mengelola hubungan industrial',
            ],
            'Marketing' => [
                'mengembangkan strategi pemasaran',
                'melaksanakan kampanye pemasaran',
                'mengelola media sosial perusahaan',
                'melakukan riset pasar',
                'mengkoordinasikan acara promosi',
            ],
            'Finance' => [
                'menyusun laporan keuangan',
                'mengelola anggaran perusahaan',
                'melakukan analisis keuangan',
                'mengelola arus kas',
                'mengawasi audit internal',
            ],
            'Operations' => [
                'mengawasi operasional harian',
                'mengelola rantai pasok',
                'mengkoordinasikan logistik',
                'menyusun jadwal produksi',
                'memastikan kepatuhan terhadap standar kualitas',
            ],
        ];

        $syarat = [
            'IT' => [
                'memiliki pemahaman akan linux',
                'menguasai SQL server',
                'S1 di bidang terkait',
                'pengalaman minimal 2 tahun',
                'kemampuan analitis yang baik',
            ],
            'HR' => [
                'S1 Psikologi, Manajemen, atau jurusan terkait',
                'pengalaman di bidang HR minimal 2 tahun',
                'kemampuan komunikasi yang baik',
                'menguasai alat tes psikologi',
                'memiliki sertifikasi HRD lebih diutamakan',
            ],
            'Marketing' => [
                'S1 Pemasaran, Komunikasi, atau jurusan terkait',
                'pengalaman di bidang pemasaran minimal 2 tahun',
                'kemampuan analisis pasar yang baik',
                'kreatif dan inovatif',
                'mampu bekerja di bawah tekanan',
            ],
            'Finance' => [
                'S1 Akuntansi, Keuangan, atau jurusan terkait',
                'pengalaman di bidang keuangan minimal 2 tahun',
                'menguasai software akuntansi',
                'kemampuan analitis yang baik',
                'teliti dan detail oriented',
            ],
            'Operations' => [
                'S1 Manajemen Operasi atau jurusan terkait',
                'pengalaman di bidang operasional minimal 2 tahun',
                'kemampuan manajerial yang baik',
                'memahami manajemen rantai pasok',
                'mampu mengelola tim',
            ],
        ];

        return [
            'posisi' => $this->faker->jobTitle(),
            'divisi' => $divisi,
            'deskripsi' => $this->faker->paragraphs(3, true),
            'jobdesk' => "- " . implode("\n- ", $this->faker->randomElements($jobdesk[$divisi], 5)),
            'syarat' => "- " . implode("\n- ", $this->faker->randomElements($syarat[$divisi], 5)),
            'lokasi_penempatan' => $this->faker->city(),
            'tipe_lamaran' => $this->faker->randomElement(['Contract', 'Internship', 'Permanent']),
            'status' => $this->faker->boolean(50),
        ];
    }


}
