<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (! $user->status_aktif) {
                Auth::logout();

                return back()->withErrors(['username' => 'Akun tidak aktif.']);
            }

            // Log login
            LogAktivitas::create([
                'id_user' => $user->id_user,
                'aktivitas' => 'Login',
                'waktu_aktivitas' => now(),
            ]);

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'petugas':
                    return redirect()->route('petugas.dashboard');
                case 'owner':
                    return redirect()->route('owner.dashboard');
                default:
                    Auth::logout();

                    return back()->withErrors(['username' => 'Role tidak valid.']);
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Log logout
            LogAktivitas::create([
                'id_user' => $user->id_user,
                'aktivitas' => 'Logout',
                'waktu_aktivitas' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
