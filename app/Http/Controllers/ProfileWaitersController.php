<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileWaitersController extends Controller
{
    public function show()
    {
        // Mengecek apakah ada data user dalam session
        if (session()->has('user')) {
            $user = session('user');
            return view('profile_waiters', compact('user'));
        }

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Mengecek apakah pengguna sudah login
            if (!session()->has('user')) {
                return redirect('/login');
            }
            return $next($request);
        });
    }

    public function edit()
{
    $user = session('user');

    // Tambahkan debug untuk memastikan data pengguna
    if (!$user) {
        return redirect('/login')->withErrors(['error' => 'User tidak ditemukan di session']);
    }

    return view('profile_waiters', compact('user'));
}


   // !error Route [profile.edit] not defined.
    public function update(Request $request)
{
    // Ambil data pengguna dari session
    $user = User::find(session('user')->id);

    // Validasi input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',
    ]);

    // Update data pengguna
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];

    // Jika password diisi, update password
    if ($request->filled('password')) {
        $user->password = bcrypt($validatedData['password']);
    }

    $user->save();

    // Perbarui data di session
    session(['user' => $user]);

    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
}

}
