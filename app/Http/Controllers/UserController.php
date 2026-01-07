<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
