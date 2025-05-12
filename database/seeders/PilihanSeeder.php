<?php

namespace Database\Seeders;

use App\Models\Pilihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PilihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_sekolah' => 1,
                'id_prodi' => 1,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 1,
                'id_prodi' => 2,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 1,
                'id_prodi' => 3,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 1,
                'id_prodi' => 4,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 1,
                'id_prodi' => 5,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 2,
                'id_prodi' => 1,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 2,
                'id_prodi' => 3,
                'created_at' => now()
            ],
            [
                'id_sekolah' => 2,
                'id_prodi' => 4,
                'created_at' => now()
            ]
        ];

        Pilihan::insert($data);
    }
}
