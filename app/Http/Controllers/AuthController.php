<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed - regenerate session
            $request->session()->regenerate();

            // Redirect to intended page or dashboard
            return redirect()->intended('dashboard');
        }

        // Authentication failed
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}