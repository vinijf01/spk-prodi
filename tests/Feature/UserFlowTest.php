<?php

namespace Tests\Feature;

use App\Models\Jurusan_Sekolah;
use App\Models\Kriteria;
use App\Models\Pertanyaan;
use App\Models\Pilihan;
use App\Models\Preferensi;
use App\Models\Prodi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_flow_sets_session_and_generates_result(): void
    {
        // Minimal dataset so AHP/TOPSIS pipeline can run.
        $sekolah = Jurusan_Sekolah::create(['nama_jurusan' => 'IPA']);

        $prodiA = Prodi::create(['nama_prodi' => 'S1 Informatika']);
        $prodiB = Prodi::create(['nama_prodi' => 'S1 Sistem Informasi']);

        Pilihan::create(['id_sekolah' => $sekolah->id, 'id_prodi' => $prodiA->id]);
        Pilihan::create(['id_sekolah' => $sekolah->id, 'id_prodi' => $prodiB->id]);

        $k1 = Kriteria::create(['nama_kriteria' => 'Minat']);
        $k2 = Kriteria::create(['nama_kriteria' => 'Bakat']);

        // Provide at least one pairwise preference so Metode\Hasil::metoda() returns data.
        Preferensi::create([
            'kriteria_1' => $k1->id,
            'kriteria_2' => $k2->id,
            'nilai' => 1,
            'keterangan' => 'Setara',
        ]);

        Pertanyaan::create([
            'id_prodi' => $prodiA->id,
            'id_kriteria' => $k1->id,
            'pertanyaan' => 'Seberapa minat kamu ke bidang ini?',
        ]);

        $this->get('/')
            ->assertOk();

        $this->post('/check', [
            'name' => 'Vini',
            'jurusansekolah_id' => $sekolah->id,
        ])
            ->assertOk()
            ->assertSessionHas('name', 'Vini')
            ->assertSessionHas('id', $sekolah->id);

        $this->post('/pertanyaan', [
            'id_prodi' => [$prodiA->id, $prodiB->id],
        ])
            ->assertOk()
            ->assertSessionHas('prodi_id', [$prodiA->id, $prodiB->id]);

        // Metode\Hasil::hasilakhir expects `data` as an array of alternatives,
        // each with a `nama` and numeric `p<ID>` entries for each criterion.
        $payload = [
            'data' => [
                [
                    'nama' => $prodiA->nama_prodi,
                    'p' . $k1->id => 5,
                    'p' . $k2->id => 3,
                ],
                [
                    'nama' => $prodiB->nama_prodi,
                    'p' . $k1->id => 3,
                    'p' . $k2->id => 5,
                ],
            ],
        ];

        $this->post('/hasilpilihan', $payload)
            ->assertOk()
            ->assertSessionHas('result');
    }
}
