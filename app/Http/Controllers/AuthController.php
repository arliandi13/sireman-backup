<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');  // Mengambil hanya email dan password dari request

        $user = User::where('email', $request->email)->first();  // Mencari user berdasarkan email yang dimasukkan

        if ($user && password_verify($request->password, $user->password)) {  // Mengecek apakah user ditemukan dan apakah password valid
            session(['user' => $user]);  // Jika login berhasil, simpan user dalam session

            switch ($user->role) {
                case 'pemilik':
                    return redirect('/dashboard-pemilik');  // Arahkan ke dashboard pemilik
                case 'kasir':
                    return redirect('/');  // Arahkan ke halaman beranda
                case 'koki':
                    return redirect('/');  // Arahkan ke dashboard koki
            }
        }

        return redirect('/login')->withErrors(['Akun Atau Password Salah!']);  // Jika kredensial tidak valid, kembali ke halaman login dengan pesan kesalahan
    }

    public function logout()
    {
        session()->flush();  // Menghapus semua data session untuk logout
        return redirect('/login');  // Setelah logout, arahkan kembali ke halaman login
    }
}

