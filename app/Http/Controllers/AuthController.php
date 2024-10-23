<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba untuk login
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            Log::info('User logged in: ' . $request->username); // Log untuk login berhasil
            // Jika berhasil login, alihkan ke dashboard
            return redirect()->route('dashboard.index')->with('success', 'Login berhasil!');
        }

        Log::warning('Failed login attempt for: ' . $request->username); // Log untuk login gagal
        // Jika gagal, kembalikan ke halaman login dengan pesan error
        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    // Tambahkan method logout jika diperlukan
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('user.login')->with('success', 'Logout berhasil!');
    }
}
