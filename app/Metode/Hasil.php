<?php

namespace App\Metode;

use App\Models\Kriteria;
use App\Models\Preferensi;

class Hasil
{

    public static function metoda()
    {
        $kriteria = Kriteria::all();
        $kriteria[0]->nilai = 1; //penamaan p1 p2 p3 v
        $namaKriteria = array(); //deklarasi array kosng untuk menyimpan nama kriteria
        $idKriteria = array();

        $i = 0;
        $y = 0;

        //perulangan nama kriteria disimpan ke variabel $namaKriteria
        foreach ($kriteria as $item) {
            $namaKriteria[$i] = $item->nama_kriteria;
            $i++;
        }
        // perulangan id kriteria
        foreach ($kriteria as $item) {
            $idKriteria[$y] = $item->id;
            $y++;
        }

        $preference = Preferensi::all(); //mengambil semua data dari model preferensi dan menyimpannya ke variabel preference
        $n = $kriteria->count(); //menghitung jml kriteria

        //menyimpan hasil pembagian nilai kriteria
        $comparation = [];

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == 0) {
                    $comparation[$i][$j] = 1; //nilai diatur menjadi 1 : prinsip dasar dalam AHP bahwa kriteria pertama selalu membandingkan dirinya sendiri dan dianggap setara
                    if ($j > $i) {
                        foreach ($preference as $value) {
                            if ($kriteria[$i]->id == $value->kriteria_1 && $kriteria[$j]->id == $value->kriteria_2) {
                                $comparation[$i][$j] = $value->nilai;
                            }
                        }
                    }
                } else {
                    if ($i == $j) {
                        $comparation[$i][$j] = 1;   // i==j; //ini berarti jika yang dibandingkan sama minat:minat (p1:p1)

                    } elseif ($i > $j) {
                        $comparation[$i][$j] = 1 / $comparation[$j][$i]; // nilai kebalikan dari posisi yang bersesuaian
                    } else {
                        // $comparation[$i][$j] = 200;
                        foreach ($preference as $value) {
                            if ($kriteria[$i]->id == $value->kriteria_1 && $kriteria[$j]->id == $value->kriteria_2) {
                                $comparation[$i][$j] = $value->nilai;
                            }
                        }
                    }
                }
            }
        }

        // dd($comparation);
        $index = 0;
        $jumlahComparation = array();

        //TOTAL setiap kolom pada matriks perbandingan berpasangan
        while ($index < $kriteria->count()) {
            $tmp = 0;
            for ($i = 0; $i < $kriteria->count(); $i++) {
                $tmp += $comparation[$i][$index];
            }
            $jumlahComparation[$index] = $tmp;
            $index++;
        }
        $total = $jumlahComparation;


        //Tabel matriks nilai kriteria (Normalisasi)
        $normalisasi = [];
        $index = 0;

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalisasi[$i][$j] = $comparation[$i][$j] / $total[$j];
            }
        }

        //mencari jumlah/total normalisasi kolom dan baris
        while ($index < $kriteria->count()) {
            // $tmp = 0;
            // for ($i = 0; $i < $kriteria->count(); $i++) {
            //     $tmp += $normalisasi[$i][$index];
            // }
            $temp = 0;

            for ($k = 0; $k < $kriteria->count(); $k++) {
                $temp += $normalisasi[$index][$k];
            }
            $jmlbarisnormalisasi[$index] = $temp;
            $prioritas[$index] = $temp / $kriteria->count();
            $eigen[$index] = ($temp / $kriteria->count()) * $total[$index];

            $index++;
        }
        $totaleigen = 0;
        $totaleigen = array_sum($eigen);

        //Rumus CI = (totaleigenvalue - totalkriteria)/(totalkriteria-1)
        $ci = ($totaleigen - $n) / ($n - 1);
        $ri = 0.58; // rasio index
        //Rumus CR=ci/ri
        $cr = $ci / $ri;


        return ([
            'namaKriteria' => $namaKriteria,
            'idKriteria' => $idKriteria,
            'comparation' => $comparation,
            'total' => $total,
            'normalisasi' => $normalisasi,
            'jmlbarisnormalisasi' => $jmlbarisnormalisasi,
            'prioritas' => $prioritas,
            'eigen' => $eigen,
            'totaleigen' => $totaleigen,
            'cr' => $cr,
            'ci' => $ci

        ]);
    }

    public static function hasilakhir($request)
    {
        $pre = Preferensi::all();
        if ($pre->count()) {
            // get data from ahp metode
            $metoda = Hasil::metoda();
        } else {
            $metoda = '';
        }

        $nama = $metoda['namaKriteria'];
        $id = $metoda['idKriteria'];


        //Mengambil data input dari $request (Si-sistem informaasi : minat 2, bakat 3, hobi 5)
        $data = $request->get('data');
        // dd($data);

        $countobj = [];
        //mengambil key dari data
        foreach ($id as $item) {
            $countobj[] = 'p' . $item; //p1, p2, p3
        }

        // Nilai alternatif
        //melakukan penggabungan data dari data yang di inputtkan (Si-sistem informaasi : minat 2, bakat 3, hobi 5) membentuk tabel
        $combainvalue = [];
        for ($a = 0; $a < count($data); $a++) {
            for ($b = 0; $b < count($countobj); $b++) {
                $temp = $countobj[$b];
                $combainvalue[$temp][] = $data[$a][$temp];
            }
        }
        // dd($combainvalue);

        //nilai total dari data yang diinputkan (TOTAL NILAI)
        $tabel_kuadrat = [];
        for ($a = 0; $a < count($data); $a++) {
            for ($b = 0; $b < count($countobj); $b++) {
                $temp = $countobj[$b];
                $tabel_kuadrat[$temp][] = $data[$a][$temp] ** 2;
            }
        }
        $ttlnilai = [];
        foreach ($tabel_kuadrat as $key => $value) {
            $ttlnilai[$key] = array_sum($value); //melooping total nilai per kriteria
        }
        // dd($ttlnilai);
        // dd($tabel_kuadrat);

        //melakukan normalisasi
        $normalisasi = [];
        for ($k = 0; $k < count($data); $k++) {
            for ($l = 0; $l < count($countobj); $l++) {
                $temp = $countobj[$l];
                $normalisasi[$temp][] = $data[$k][$temp] / sqrt($ttlnilai['p' . $l + 1]);
            }
        }
        // dd($normalisasi);

        //normalisasi terbobot
        $bobot = $metoda['prioritas'];
        $normalisasi_terbobot = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($countobj); $j++) {
                $temp = $countobj[$j];
                $normalisasi_terbobot[$temp][] = $normalisasi[$temp][$i] * $bobot[$j];
            }
        }
        // dd($normalisasi_terbobot);

        //Matrik Solusi Ideal
        //positif
        $positif = [];
        foreach ($normalisasi_terbobot as $nt => $value) {
            $positif[$nt] = max($value); //melooping nilai max per kriteria
        }
        // dd($positif);
        //negatif
        $negatif = [];
        foreach ($normalisasi_terbobot as $nt => $value) {
            $negatif[$nt] = min($value); //melooping nilai max per kriteria
        }
        // dd($negatif);

        //Nilai Jarak ideal Positif
        $jarak_ideal_positif = [];
        for ($i = 0; $i < count($data); $i++) {
            $jml_temp = 0;
            for ($j = 0; $j < count($countobj); $j++) {
                $temp = ($normalisasi_terbobot[$countobj[$j]][$i] - $positif[$countobj[$j]]) ** 2;
                $jml_temp += $temp;
            }
            $jarak_ideal_positif[$i] = sqrt($jml_temp); // Menggunakan akar kuadrat untuk Euclidean Distance
        }
        // dd($jarak_ideal_positif);

        //Nilai Jarak ideal Negatif
        $jarak_ideal_negatif = [];
        for ($i = 0; $i < count($data); $i++) {
            $jml_temp = 0;
            for ($j = 0; $j < count($countobj); $j++) {
                $temp = ($normalisasi_terbobot[$countobj[$j]][$i] - $negatif[$countobj[$j]]) ** 2;
                $jml_temp += $temp;
            }
            $jarak_ideal_negatif[$i] = sqrt($jml_temp); // Menggunakan akar kuadrat untuk Euclidean Distance
        }
        // dd($jarak_ideal_negatif);

        // Menghitung nilai Preferensi
        $preferensi = [];
        for ($i = 0; $i < count($data); $i++) {
            $np = $jarak_ideal_negatif[$i] / ($jarak_ideal_positif[$i] + $jarak_ideal_negatif[$i]);
            $preferensi[$i] = $np;
        }
        // dd($preferensi);
        $change_preferensi = [];
        for ($i = 0; $i < count($data); $i++) {
            $change_preferensi[$data[$i]['nama']][] = $preferensi[$i];
        }
        arsort($change_preferensi);
        $prodi_max = array_keys($change_preferensi)[0];
        // dd($namaProdiTeratas);

        // dd($preferensi);
        return ([
            'data' => $data,
            'id' => $id,
            'countobj' => $countobj,
            'combainvalue' => $combainvalue,
            'normalisasi' => $normalisasi,
            'normalisasi_terbobot' => $normalisasi_terbobot,
            'tabel_tn' => $tabel_kuadrat,
            'ttlnilai' => $ttlnilai,
            'nama' => $nama,
            'bobot' => $bobot,
            'positif' => $positif,
            'negatif' => $negatif,
            'jr_positif' => $jarak_ideal_positif,
            'jr_negatif' => $jarak_ideal_negatif,
            'preferensi' => $preferensi,
            'change_preferensi' => $change_preferensi,
            'prodi_max' => $prodi_max
        ]);
    }
}
