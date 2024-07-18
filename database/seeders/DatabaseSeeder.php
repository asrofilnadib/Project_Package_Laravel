<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\Pendaftaran;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        /*User::factory(5)->create();
        Lowongan::factory(10)->create();
        Pendaftaran::factory(50)->create();
        */

        $this->call([
            CustomerSeeder::class
        ]);

    }
}
