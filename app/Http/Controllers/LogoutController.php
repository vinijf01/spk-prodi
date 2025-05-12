<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function perform()
    {
        //untuk menghapus semua nilai pada session
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
