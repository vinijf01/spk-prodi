<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataprodi = [
            [
                'nama_prodi' => 'S1-Sistem Informasi',
                'created_at' => now()
            ],
            [
                'nama_prodi' => 'S1-Informatika',
                'created_at' => now()
            ],
            [
                'nama_prodi' => 'S1-Bisnis Digital',
                'created_at' => now()
            ],
            [
                'nama_prodi' => 'S1-Manajemen Ritel',
                'created_at' => now()
            ],
            [
                'nama_prodi' => 'S1-Desain Komunikasi Visual',
                'created_at' => now()
            ],
        ];
        Prodi::insert($dataprodi);
    }
}
