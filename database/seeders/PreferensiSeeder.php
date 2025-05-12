<?php

namespace Database\Seeders;

use App\Models\Preferensi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kriteria_1' => 1,
                'nilai' => 2,
                'keterangan' => 'Sama Pentingnya',
                'kriteria_2' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kriteria_1' => 1,
                'nilai' => 7,
                'keterangan' => 'Sangat penting',
                'kriteria_2' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kriteria_1' => 2,
                'nilai' => 5,
                'keterangan' => 'Penting dari',
                'kriteria_2' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        Preferensi::insert($data);
    }
}
