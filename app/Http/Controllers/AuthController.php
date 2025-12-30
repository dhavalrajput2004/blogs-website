<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('posts.index');
        }
        return response()->view('auth.login')->header('Cache-Control', 'no-cache, no-store');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $validated =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($validated)) {
            return redirect()->route('posts.index');
        }

        return back()->withErrors([
            'email' => 'email does not match.',
            'password' => 'password does not match.',
        ]);
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('posts.index');
        }
        return response()->view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        
        return redirect()->route('posts.index')->withSuccess('registered successfully');
    }

    public function logOut()
    {
        Auth::logout();
        return redirect('login');
    }
}
