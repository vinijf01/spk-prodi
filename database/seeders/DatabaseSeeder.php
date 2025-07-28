<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pertanyaan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UsersSeeder::class,
            JurusanSekolahSeeder::class,
            KriteriaSeeder::class,
            ProdiSeeder::class,
            PertanyaanSeeder::class,
            PilihanSeeder::class,
            PreferensiSeeder::class,
        ]);


        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
