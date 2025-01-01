<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    // Menampilkan halaman login-customer.blade.php
    public function showLoginForm()
    {
        return view('login-customer');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            // Simpan session customer
            session(['customer' => $customer]);

            return redirect('/')->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['error' => 'Email atau password salah']);
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Simpan session customer setelah registrasi
        session(['customer' => $customer]);

        return redirect('/login-customer')->with('success', 'Berhasil mendaftar!');
    }

    // Logout
    public function logout()
    {
        session()->forget('customer');

        return redirect('/')->with('success', 'Berhasil logout!');
    }

    // Dashboard untuk customer
    public function dashboard()
    {
        if (!session()->has('customer')) {
            return redirect('/login-customer')->withErrors(['error' => 'Silakan login terlebih dahulu!']);
        }

        $customer = session('customer');

        return view('customer.dashboard', compact('customer'));
    }
}
