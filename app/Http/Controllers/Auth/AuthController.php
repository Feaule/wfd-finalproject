<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()  { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'no_ktp'   => 'required|string|min:16|max:16',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_ktp'   => $request->no_ktp,
            'password' => Hash::make($request->password),
            'role'     => 'penghuni',
            'status'   => 'pending',
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Tunggu persetujuan admin.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek status penghuni - tolak jika pending/rejected
        if ($user && $user->role === 'penghuni' && $user->status !== 'active') {
            return back()->withErrors(['email' => 'Akun kamu belum disetujui admin.']);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();
            // Redirect sesuai role
            return auth()->user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('penghuni.tagihan.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}