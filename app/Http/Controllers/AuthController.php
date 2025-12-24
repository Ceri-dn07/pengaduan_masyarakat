<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Masyarakat;
use App\Models\Petugas;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $user = \App\Models\Masyarakat::where('username', $credentials['username'])->first();

        if ($user) {
            if (Hash::check($credentials['password'], $user->password)) {
                Auth::guard('masyarakat')->login($user);
                return redirect()->intended('/user/dashboard');
            }
        }

        return back()->withErrors([
            'login_error' => 'Username atau password salah.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|digits:16|unique:masyarakat,nik',
            'nama' => 'required|string|max:35',
            'username' => 'required|string|max:25|unique:masyarakat,username',
            'password' => 'required|string|min:8',
            'telp' => 'required|digits_between:10,13',
        ]);
        
        $user = Masyarakat::create([
            'nik' => $validatedData['nik'],
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'telp' => $validatedData['telp'],
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Arahkan ke halaman setelah registrasi
        return redirect('/login')->with('success', 'Registrasi berhasil.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Admin atau petugas
    public function showLoginAdminForm()
    {
        return view('admin.auth.login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $petugas = Petugas::where('username', $credentials['username'])->first();

        if ($petugas) {
            if (Hash::check($credentials['password'], $petugas->password)) {   
                Auth::guard('petugas')->login($petugas);

                if ($petugas->level === 'admin') {
                    return redirect()->intended('/admin/dashboard');
                } elseif ($petugas->level === 'petugas') {
                    return redirect()->intended('/petugas/dashboard');
                }
            }
        }
        
        return redirect()->intended('/login-admin')->withErrors([
            'login_error' => 'Username atau password salah.',
        ]);
    }

    public function registerAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'nama_petugas' => 'required|string|max:35',
            'username' => 'required|string|max:25|unique:masyarakat,username',
            'password' => 'required|string|min:8',
            'telp' => 'required|digits_between:10,13',
        ]);
        
        $user = Petugas::create([
            'nama_petugas' => $validatedData['nama_petugas'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'telp' => $validatedData['telp'],
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Arahkan ke halaman setelah registrasi
        return redirect('/login')->with('success', 'Registrasi berhasil.');
    }
}
