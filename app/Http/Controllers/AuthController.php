<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Fungsi untuk melakukan registrasi user baru.
     */
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'required|string',
            'address'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('landing')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'phone'    => $request->phone,
                'address'  => $request->address,
            ]);

            Auth::login($user);
            // Tambahkan flash message untuk pendaftaran
            session()->flash('success_register', 'Pendaftaran berhasil! Selamat datang, ' . $user->name);
            return $this->redirectBasedOnRole($user);
        } catch (\Exception $e) {
            return redirect()->route('landing')
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Fungsi untuk melakukan proses login.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('landing')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Gunakan key flash yang konsisten, misalnya 'success_login'
            session()->flash('success_login', 'Login berhasil! Selamat datang, ' . $user->name);
            return $this->redirectBasedOnRole($user);
        }

        // Jika kredensial tidak valid
        return redirect()->route('landing')
            ->withErrors(['error' => 'Email atau password tidak valid.'])
            ->withInput();
    }


    /**
     * Fungsi untuk logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tambahkan flash message logout
        session()->flash('success_logout', 'Logout berhasil! Sampai jumpa lagi.');

        return redirect()->route('landing');
    }


    /**
     * Fungsi pembantu untuk mengarahkan user berdasarkan role-nya.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back();
    }
}
