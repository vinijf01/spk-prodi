<?php

namespace App\Http\Controllers;

use App\Http\Requests\HasilPilihanRequest;
use App\Http\Requests\PertanyaanProdiRequest;
use App\Http\Requests\PilihanProdiRequest;
use App\Models\Jurusan_Sekolah;
use App\Models\Kriteria;
use App\Models\Pertanyaan;
use App\Models\Pilihan;
use App\Models\Prodi;
use App\Services\SpkService;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    protected SpkService $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    public function index()
    {
        $jurusanSekolah = Jurusan_Sekolah::all();
        return view('welcome', compact('jurusanSekolah'));
    }

    public function pilihanProdi(PilihanProdiRequest $request)
    {
        $validated = $request->validated();

        $request->session()->put('name', $validated['name']);
        $request->session()->put('id', $validated['jurusansekolah_id']);

        // Menggunakan custom_id saat mencari sekolah
        $sekolah = Jurusan_Sekolah::find($request->session()->get('id'));
        $available = Pilihan::whereIdSekolah($sekolah->id)->get();

        return view('users.proses.select', compact('available', 'sekolah'));
    }

    public function pertanyaan(PertanyaanProdiRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('prodi_id', $validated['id_prodi']);

        $idProdi = $request->session()->get('prodi_id');
        $prodi = Prodi::whereIn('id', $idProdi)->get();
        $kriteria = Kriteria::all();
        $pertanyaan = Pertanyaan::all();

        return view('users.proses.pertanyaan', compact('prodi', 'kriteria', 'pertanyaan'));
    }

    public function hasilPilihan(HasilPilihanRequest $request)
    {
        $ahp = $this->spkService->hitungBobot();
        $dataAlternatif = $request->input('data');

        // Pastikan data bobot ada sebelum hitung peringkat
        if (empty($ahp) || empty($ahp['prioritas'])) {
            // Fallback atau error handling jika AHP belum disetting
            $result = [];
        } else {
            $result = $this->spkService->hitungPeringkat(
                $dataAlternatif,
                $ahp['prioritas'],
                $ahp['idKriteria'],
                $ahp['namaKriteria'] ?? []
            );
            // Merge data AHP yang dibutuhkan view
            $result['comparation'] = $ahp['comparation'] ?? [];
            $result['total'] = $ahp['total'] ?? [];
            $result['ci'] = $ahp['ci'] ?? 0;
            $result['cr'] = $ahp['cr'] ?? 0;
        }

        $request->session()->put('result', $result);

        return view('users.proses.hasil_pilihan', [
            'result' => $result
        ]);
    }

    // public function createPDF(Request $request)
    // {
    //     if (!$request->session()->get('result')) {
    //         return redirect()->route('dashboard-user');
    //     }

    //     // dd($request->session()->get('result'));


    //     $filename = 'hasil_rekomendasi_prodi.pdf';

    //     $data = [
    //         'title' => 'Hasil Rekomendasi Program Studi',
    //         'result' => $request->session()->get('result')
    //     ];

    //     $html = view()->make('users.proses.cetak_pdf', $data)->render();

    //     $pdf = new TCPDF();

    //     $pdf::SetTitle('Hasil Rekomendasi Program Studi'); //title di tag <title></title>
    //     $pdf::AddPage();
    //     //output html content
    //     //param : html,In,Fill,reseth,cell, align 
    //     $pdf::writeHTML($html, true, false, true, true, '');

    //     //param : name , dest F : menyimpan ke lokal dengan nama sesuai param name
    //     $pdf::Output(public_path($filename), 'F');

    //     // return $data;

    //     return response()->download(public_path($filename));
    // }
    public function createPDF(Request $request)
    {
        $result = $request->session()->get('result');

        if (!$result) {
            // Route `dashboard-user` tidak terdefinisi di repo ini; kembali ke landing page.
            return redirect()->route('index');
        }

        $filename = 'hasil_rekomendasi_prodi.pdf';

        $data = [
            'title' => 'Hasil Rekomendasi Program Studi',
            'result' => $result,
            'user' => session('name') ?? 'Pengguna'
        ];

        $html = view('users.proses.cetak_pdf', $data)->render();

        // Inisialisasi TCPDF
        $pdf = new \TCPDF();

        // Atur properti dasar PDF
        $pdf->SetTitle($data['title']);
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        // Tulis konten HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Simpan ke file publik
        $pdf->Output(public_path($filename), 'F');

        // Unduh file
        return response()->download(public_path($filename));
    }
}
