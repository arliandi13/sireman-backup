<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Import class Request untuk menangani HTTP request.
use Illuminate\Support\Facades\Auth; // Import class Auth untuk autentikasi (tidak digunakan di sini).
use Illuminate\Support\Facades\Hash; // Import class Hash untuk hash password.
use App\Models\Customer; // Import model Customer untuk mengakses tabel `customers`.

class CustomerAuthController extends Controller
{
    // Menampilkan halaman login-customer.blade.php
    public function showLoginForm()
    {
        // Menampilkan view login-customer untuk halaman login.
        return view('login-customer');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input untuk memastikan email dan password terisi dan sesuai format.
        $request->validate([
            'email' => 'required|email', // Email harus ada dan valid.
            'password' => 'required', // Password harus ada.
        ]);

        // Cari customer berdasarkan email yang diberikan.
        $customer = Customer::where('email', $request->email)->first();

        // Periksa apakah customer ditemukan dan password cocok.
        if ($customer && Hash::check($request->password, $customer->password)) {
            // Simpan data customer ke dalam session.
            session(['customer' => $customer]);

            // Redirect ke halaman utama dengan pesan sukses.
            return redirect('/')->with('success', 'Berhasil login!');
        }

        // Jika email atau password salah, kembalikan ke halaman login dengan pesan error.
        return back()->withErrors(['error' => 'Email atau password salah']);
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input untuk memastikan data sesuai ketentuan.
        $request->validate([
            'name' => 'required|string|max:255', // Nama harus diisi, string, dan maksimal 255 karakter.
            'email' => 'required|email|unique:customers,email', // Email harus valid dan unik.
            'password' => 'required|min:6|confirmed', // Password harus minimal 6 karakter dan terkonfirmasi.
        ]);

        // Buat instance baru dari model Customer.
        $customer = new Customer();
        $customer->name = $request->name; // Set nama dari input request.
        $customer->email = $request->email; // Set email dari input request.
        $customer->password = Hash::make($request->password); // Hash password sebelum menyimpan.
        $customer->save(); // Simpan data customer ke database.

        // Simpan data customer ke dalam session setelah registrasi.
        session(['customer' => $customer]);

        // Redirect ke halaman login dengan pesan sukses.
        return redirect('/login-customer')->with('success', 'Berhasil mendaftar!');
    }

    // Logout
    public function logout()
    {
        // Hapus data session customer.
        session()->forget('customer');

        // Redirect ke halaman utama dengan pesan sukses.
        return redirect('/')->with('success', 'Berhasil logout!');
    }
}
