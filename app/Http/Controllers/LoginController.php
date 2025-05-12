<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login', [
            "title" => 'Login'
        ]);
    }

    public function login(Request $request)
    {
        // dd($request);
        $credential = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/admin');
        }
        return back()->with('inputError', 'Login Failed');
    }
}
