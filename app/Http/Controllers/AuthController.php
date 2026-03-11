<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }
        return back()
            ->withErrors(['email' => 'These credentials not match our records.'])
            ->withInput($request->except('password'));
    }

    function register(RegisterRequest $request)
    {
        $validateData = $request->validated();
        $user = User::create(
            [
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'password' => Hash::make($validateData['password'])
            ]
        );

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
