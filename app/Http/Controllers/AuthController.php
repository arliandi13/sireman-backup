<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    $user = User::where('email', $request->email)->first();

    if ($user && password_verify($request->password, $user->password)) {
        session(['user' => $user]);

        switch ($user->role) {
            case 'pemilik':
                return redirect('/dashboard-pemilik');
            case 'kasir':
                return redirect('/');
            case 'waiters':
                return redirect('/');
            case 'koki':
                return redirect('/dashboard-koki');
        }
    }

    return redirect('/login')->withErrors(['Invalid credentials']);
}


    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
