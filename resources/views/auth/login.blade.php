@extends('layouts.app')
<div class="mx-auto p-2" style="width: 400px;">
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.post') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type = "password" name="password" class="form-control" required>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Login</button>
    </form>
</div>
