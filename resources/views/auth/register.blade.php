@extends('layouts.app')
<div class="mx-auto p-2" style="width: 400px;">
    <!-- He who is contented is rich. - Laozi -->
    <h1>Register</h1>
    <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
        @csrf 
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="passsword">Password</label>
            <input type = "password" name="password" class="form-control" required>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>
