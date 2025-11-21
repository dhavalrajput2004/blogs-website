<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function postLogin(Request $request):RedirectResponse 
    {
        $validated =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($validated)) {
            return redirect()->route('posts.index');
        }
        
        return back()->withErrors([
            'email' => 'email does not match.',
            'password' => 'password does not match.',
        ]);
    }

    public function register() {
        return view('auth.register');
    }

    public function postRegister(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        return redirect()->route('posts.index')->withSuccess('registered successfully');
    }

    public function logOut(Request $request) {
        Auth::logout();
        return redirect('login');
    }
}
