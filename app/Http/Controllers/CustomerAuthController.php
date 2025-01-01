<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    // Halaman login
    public function showLoginForm()
    {
        return view('login'); // Sesuaikan dengan view login Anda
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return redirect()->route('customer.dashboard'); // Ganti dengan route dashboard Anda
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Proses logout
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('login'); // Ganti dengan route login Anda
    }

    // Halaman register
    public function showRegisterForm()
    {
        return view('register'); // Buat view untuk registrasi
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}
