<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        if (session()->has('user')) {
            $user = session('user');
            return view('profile', compact('user'));
        }

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session()->has('user')) {
                return redirect('/login');
            }
            return $next($request);
        });
    }

    public function edit()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->withErrors(['error' => 'User tidak ditemukan di session']);
        }

        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(session('user')->id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();
        session(['user' => $user]);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
