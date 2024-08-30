<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login', [
            'title' => 'Halaman Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nrp' => 'required|numeric',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin'){
                return redirect('/posts');
            } elseif ($user->role === 'user'){
                return redirect('/permintaan');
            } else {
                return redirect('/permintaan')->with('error', 'Akun belum di verifikasi');
            }

            // return redirect()->intended('dashboard');
        }
        
        return back()->with('LoginError', 'Login gagal!, silahkan coba lagi');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
