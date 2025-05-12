<?php

namespace App\Http\Controllers;

use App\Metode\Hasil as MetodeHasil;
use App\Models\Jurusan_Sekolah;
use App\Models\Kriteria;
use App\Models\Pertanyaan;
use App\Models\Pilihan;
use App\Models\Prodi;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function index()
    {
        $jurusanSekolah = Jurusan_Sekolah::all();
        return view('welcome', compact('jurusanSekolah'));
    }

    public function pilihanProdi(Request $request)
    {
        $request->session()->put('name', $request->input('name'));
        $request->session()->put('id', $request->input('jurusansekolah_id'));

        // Menggunakan custom_id saat mencari sekolah
        $sekolah = Jurusan_Sekolah::find($request->session()->get('id'));
        $available = Pilihan::whereIdSekolah($sekolah->id)->get();

        return view('users.proses.select', compact('available', 'sekolah'));
    }

    public function pertanyaan(Request $request)
    {
        $request->session()->put('prodi_id', $request->input('id_prodi'));

        $idProdi = $request->session()->get('prodi_id');
        $prodi = Prodi::whereIn('id', $idProdi)->get();
        $kriteria = Kriteria::all();
        $pertanyaan = Pertanyaan::all();

        return view('users.proses.pertanyaan', compact('prodi', 'kriteria', 'pertanyaan'));
    }

    public function hasilPilihan(Request $request)
    {
        // return $request->all();
        // return Hasil::hasilakhir($request);
        $request->session()->put('result', MetodeHasil::hasilakhir($request));
        // dd($request->session()->get('result'));


        return view('users.proses.hasil_pilihan', [
            'result' => MetodeHasil::hasilakhir($request)
        ]);
    }

    public function createPDF(Request $request)
    {
        if (!$request->session()->get('result')) {
            return redirect()->route('dashboard-user');
        }

        $filename = 'hasil_rekomendasi_prodi.pdf';

        $data = [
            'title' => 'Hasil Rekomendasi Program Studi',
            'result' => $request->session()->get('result')
        ];

        $html = view()->make('users.proses.cetak_pdf', $data)->render();

        $pdf = new TCPDF();

        $pdf::SetTitle('Hasil Rekomendasi Program Studi'); //title di tag <title></title>
        $pdf::AddPage();
        //output html content
        //param : html,In,Fill,reseth,cell, align 
        $pdf::writeHTML($html, true, false, true, true, '');

        //param : name , dest F : menyimpan ke lokal dengan nama sesuai param name
        $pdf::Output(public_path($filename), 'F');

        // return $data;

        return response()->download(public_path($filename));
    }
}
