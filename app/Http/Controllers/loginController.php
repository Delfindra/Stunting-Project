<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class loginController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // Menyimpan data email dan password dari request
        $credentials = $request->only('email', 'password');
    
        // Mengecek jika form kosong
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return back()->withErrors([
                'email' => 'Pastikan semua data terisi dengan benar!',
            ]);
        }
    
        // Mengecek email apakah terdaftar
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'email tidak terdaftar!',
            ]);
        }
    
        // Mencoba login dengan password yang salah
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'password salah!',
            ]);
        }
    
        // Jika autentikasi berhasil, regenerasi session dan redirect
        $request->session()->regenerate();
        return redirect()->intended('/'); 
    }

    // public function register(Request $request)
    // {
    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
    
    //     // Mengecek jika validasi gagal
    //     if ($validator->fails()) {
    //         return Redirect::back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }
    
    //     // Membuat pengguna baru
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);
    
    //     // Login pengguna baru
    //     Auth::login($user);
    
    //     // Redirect ke halaman login dengan pesan sukses
    //     return redirect('/login')->with('success', 'Account successfully registered.');
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); 
    }
}
