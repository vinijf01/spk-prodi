<?php

namespace App\Http\Controllers;

use App\Models\Jurusan_Sekolah;
use App\Models\Preferensi;
use App\Models\Prodi;
use App\Metode\Hasil as MetodeHasil;
use App\Models\Kriteria;
use App\Models\Pertanyaan;
use App\Models\Pilihan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $prodi = Prodi::count();
        $user = User::count();
        $j_sekolah = Jurusan_Sekolah::count();

        return view('admin.index', [
            'title' => 'Dashboard',
            'active' => 'admin',
            'prodi' => $prodi,
            'user' => $user,
            'sekolah' => $j_sekolah

        ]);
    }

    public function profile()
    {
        $id = Auth::id();
        $user = User::find($id);
        return view('admin.profile', [
            'title' => 'Profile',
            'active' => 'profile',
            'user' => $user
        ]);
    }
}
