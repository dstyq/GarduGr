<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menangani proses login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'username' => 'required|string',  
            'password' => 'required|string', 
        ]);

        // Mendapatkan kredensial dari input pengguna
        $credentials = ['username' => $request->username, 'password' => $request->password];

        // Coba untuk login menggunakan kredensial
        if (Auth::attempt($credentials, $request->remember)) {
            // Jika login berhasil, catat log dan alihkan ke dashboard
            Log::info('User logged in: ' . $request->username);
            return redirect()->route('dashboard.index')->with('success', 'Login berhasil!');
        }

        // Jika login gagal, catat log dan lemparkan error
        Log::warning('Failed login attempt for: ' . $request->username);
        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'], 
        ]);
    }

    /**
     * Menangani proses logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Proses logout dan hapus sesi pengguna
        Auth::logout();
        
        // Alihkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('user.login')->with('success', 'Logout berhasil!');
    }
}
