<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login_view');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
