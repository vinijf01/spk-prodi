<?php

namespace App\Http\Controllers;

use App\Models\Jurusan_Sekolah;
use App\Models\Pilihan;
use App\Models\Prodi;
use Illuminate\Http\Request;

class PilihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.pilihan.index', [
            "title" => 'Pilihan',
            "active" => 'pilihan',
            "jurusansekolah" => Jurusan_Sekolah::with('pilihan')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {

        Pilihan::whereIdSekolah($id)->delete();
        $pilihan = request('pilihan');

        if ($pilihan != null) {
            foreach ($pilihan as $item) {
                Pilihan::create([
                    'id_sekolah' => $id,
                    'id_prodi' => $item
                ]);
            }
        }

        return redirect()->route('admin-pilihan.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $arrayIndex = 0;
        $idJurusanSekolah = $id;
        $jurusansekolah = Jurusan_Sekolah::find($id);
        $prodis = Prodi::all();

        return view('admin.pilihan.create', [
            'prodis' => $prodis,
            'arrayIndex' => $arrayIndex,
            'title' => 'Pilihan',
            'active' => 'pilihan',
            'jurusansekolah' => $jurusansekolah,
            'idJurusanSekolah' => $idJurusanSekolah
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pilihan = Pilihan::find($id);
        return view('admin.pilihan.edit', [
            'title' => 'Pilihan',
            'active' => 'pilihan',
            "jurusansekolah" => Jurusan_Sekolah::all(),
            "prodi" => Prodi::all(),
            'pilihan' => $pilihan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Pilihan::find($id);
        $data->update($request->all());
        return redirect()->route('admin-pilihan.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pilihan::find($id);
        $data->delete();
        return redirect()->route('admin-pilihan.index')->with('success', 'Data Berhasil Dihapus');
    }
}
