<?php

namespace App\Http\Controllers;







use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
          //  'name' => ['required', 'string', 'max:255'],
          //  'username' => ['required', 'string', 'max:255', 'unique:users'],
           
          //  'password' => ['required', 'confirmed', Rules\Password::defaults()],
          //  'privilege' => ['required', 'in:admin,manager,employee'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
           
            'password' => Hash::make($request->password),
            'privilege' => $request->privilege,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}