<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSOController extends Controller
{

    public function login()
    {
        return view('sso.login');
    }

    public function logout()
    {
        session()->forget(['token', 'user']);
        return redirect('/login');
    }

    public function dashboard()
    {
        $user = session('user'); // Ambil user dari session
        if (!$user) {
            return redirect('/login'); // Jika user tidak ditemukan, maka lempar ke login
        }
        return view('sso.dashboard', compact('user'));
    }
}
