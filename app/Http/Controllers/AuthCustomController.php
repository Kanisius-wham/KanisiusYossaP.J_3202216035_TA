<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Pemilik;

class AuthCustomController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.custom-login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in:admin,pemilik',
        ]);

        // ...
if ($request->role === 'admin') {
    $user = Admin::where('username', $request->username)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        session(['role' => 'admin', 'admin_id' => $user->id, 'username' => $user->username]);
        return redirect()->route('admin.alat.index');
    }
} elseif ($request->role === 'pemilik') {
    $user = Pemilik::where('username', $request->username)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        session(['role' => 'pemilik', 'pemilik_id' => $user->id, 'username' => $user->username]);
        return redirect()->route('admin.alat.index');
    }
}


        return back()->with('error', 'Username atau password salah!');
    }

    // Dashboard bersama
    public function dashboard()
    {
        if (!session('role')) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
