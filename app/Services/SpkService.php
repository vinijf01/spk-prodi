<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Preferensi;
use Illuminate\Support\Collection;

class SpkService
{
    /**
     * Menghitung bobot kriteria menggunakan metode AHP.
     *
     * @param Collection|null $kriteria
     * @param Collection|null $preferensi
     * @return array
     */
    public function hitungBobot(?Collection $kriteria = null, ?Collection $preferensi = null): array
    {
        $kriteria = $kriteria ?? Kriteria::all();
        $preferensi = $preferensi ?? Preferensi::all();

        if ($kriteria->isEmpty()) {
            return [];
        }

        $n = $kriteria->count();
        $comparation = [];

        // Matriks Perbandingan Berpasangan
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) {
                    $comparation[$i][$j] = 1;
                } elseif ($i < $j) {
                    // Cari nilai preferensi
                    $nilai = 1; // Default jika tidak ada preferensi
                    $pref = $preferensi->firstWhere(function ($p) use ($kriteria, $i, $j) {
                        return $p->kriteria_1 == $kriteria[$i]->id && $p->kriteria_2 == $kriteria[$j]->id;
                    });
                    if ($pref) {
                        $nilai = $pref->nilai;
                    }
                    $comparation[$i][$j] = $nilai;
                } else {
                    // Invers dari posisi simetris
                    $comparation[$i][$j] = 1 / $comparation[$j][$i];
                }
            }
        }

        // Total Kolom
        $totalKolom = [];
        for ($j = 0; $j < $n; $j++) {
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {
                $sum += $comparation[$i][$j];
            }
            $totalKolom[$j] = $sum;
        }

        // Normalisasi & Prioritas
        $prioritas = [];
        for ($i = 0; $i < $n; $i++) {
            $sumBaris = 0;
            for ($j = 0; $j < $n; $j++) {
                $sumBaris += ($comparation[$i][$j] / $totalKolom[$j]);
            }
            $prioritas[$i] = $sumBaris / $n;
        }

        // Konsistensi (CI & CR)
        // Lambda Max = sum(prioritas[i] * totalKolom[i])
        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            $lambdaMax += $prioritas[$i] * $totalKolom[$i];
        }

        $ci = ($lambdaMax - $n) / ($n - 1);
        // RI tabel standar (n=1..10), default 0.58 untuk n=3
        $riTable = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49];
        $ri = $riTable[$n] ?? 0.58;
        $cr = $ri != 0 ? $ci / $ri : 0;

        return [
            'namaKriteria' => $kriteria->pluck('nama_kriteria')->toArray(),
            'idKriteria' => $kriteria->pluck('id')->toArray(),
            'comparation' => $comparation,
            'total' => $totalKolom,
            'prioritas' => $prioritas,
            'ci' => $ci,
            'cr' => $cr,
        ];
    }

    /**
     * Menghitung peringkat alternatif menggunakan metode TOPSIS.
     *
     * @param array $dataAlternatif Format: [['nama' => 'Prodi A', 'p1' => 5, 'p2' => 3], ...]
     * @param array $bobot Array bobot dari hitungBobot()['prioritas']
     * @param array $idKriteria Array ID kriteria
     * @param array $namaKriteria Array nama kriteria (opsional, untuk view)
     * @return array
     */
    public function hitungPeringkat(array $dataAlternatif, array $bobot, array $idKriteria, array $namaKriteria = []): array
    {
        if (empty($dataAlternatif) || empty($bobot)) {
            return [];
        }

        $countobj = array_map(fn($id) => 'p' . $id, $idKriteria);

        // 1. Normalisasi Denominator (sqrt(sum(x^2)))
        $denominator = [];
        foreach ($countobj as $key) {
            $sumSq = 0;
            foreach ($dataAlternatif as $alt) {
                $val = $alt[$key] ?? 0;
                $sumSq += pow($val, 2);
            }
            $denominator[$key] = sqrt($sumSq);
        }

        // 2. Matriks Ternormalisasi & Terbobot
        $normalisasi = [];
        $normalisasiTerbobot = [];
        foreach ($dataAlternatif as $idx => $alt) {
            foreach ($countobj as $j => $key) {
                $val = $alt[$key] ?? 0;
                $norm = $denominator[$key] != 0 ? $val / $denominator[$key] : 0;
                $normalisasi[$key][$idx] = $norm;
                // Struktur lama: ['p1' => [val_alt1, val_alt2], 'p2' => [...]]
                $normalisasiTerbobot[$key][$idx] = $norm * ($bobot[$j] ?? 0);
            }
        }

        // 3. Solusi Ideal Positif (A+) dan Negatif (A-)
        $apos = [];
        $aneg = [];
        foreach ($countobj as $key) {
            $vals = $normalisasiTerbobot[$key] ?? [];
            $apos[$key] = !empty($vals) ? max($vals) : 0;
            $aneg[$key] = !empty($vals) ? min($vals) : 0;
        }

        // 4. Jarak ke Solusi Ideal
        $dPos = [];
        $dNeg = [];
        $numAlt = count($dataAlternatif);
        for ($i = 0; $i < $numAlt; $i++) {
            $sumPos = 0;
            $sumNeg = 0;
            foreach ($countobj as $key) {
                $val = $normalisasiTerbobot[$key][$i] ?? 0;
                $sumPos += pow($val - $apos[$key], 2);
                $sumNeg += pow($val - $aneg[$key], 2);
            }
            $dPos[$i] = sqrt($sumPos);
            $dNeg[$i] = sqrt($sumNeg);
        }

        // 5. Nilai Preferensi (V)
        $preferensi = [];
        foreach ($dataAlternatif as $idx => $alt) {
            $v = ($dPos[$idx] + $dNeg[$idx]) != 0 ? $dNeg[$idx] / ($dPos[$idx] + $dNeg[$idx]) : 0;
            $preferensi[$idx] = $v;
        }

        // Mapping ke nama prodi dan sort
        $hasil = [];
        foreach ($dataAlternatif as $idx => $alt) {
            $hasil[$alt['nama']][] = $preferensi[$idx]; // Wrap in array to match old view expectation
        }
        arsort($hasil);

        $prodiMax = key($hasil);

        return [
            'data' => $dataAlternatif,
            'id' => $idKriteria,
            'countobj' => $countobj,
            'normalisasi' => $normalisasi,
            'normalisasi_terbobot' => $normalisasiTerbobot,
            'positif' => $apos,
            'negatif' => $aneg,
            'jr_positif' => $dPos,
            'jr_negatif' => $dNeg,
            'preferensi' => $preferensi,
            'change_preferensi' => $hasil,
            'prodi_max' => $prodiMax,
            // Keys tambahan untuk kompatibilitas view lama
            'nama' => $namaKriteria,
            'bobot' => $bobot,
            'tabel_tn' => [],
            'ttlnilai' => [],
            'combainvalue' => [],
        ];
    }
}
