<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function loginUser(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($validate)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $profile = Pegawai::select(['namaPegawai'])->where('idUser', $user['idUser'])->first();

            $request->session()->put('namaProfile', $profile['namaPegawai']);

            if ($user['role'] === 'GURU') {
                return redirect()->intended('home');
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
