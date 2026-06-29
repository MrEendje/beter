<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on role
            if (Auth::user()->role === 'administrator') {
                return redirect()->intended('/admin/medewerkers');
            }

            if (Auth::user()->role === 'medewerker') {
                return redirect()->intended('/medewerker/tickets');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'De opgegeven inloggegevens komen niet overeen met onze bestanden.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
