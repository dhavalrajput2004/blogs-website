@extends('layouts.app')
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
<div class="navbar border-bottom border-body justify-content-start gap-4 ms-4">
    @if(Auth::check() && $user)
    <ul class="nav justify-content-end mb-2">
      
        <li class="nav-item">
            <a class="nav-link disabled" href="#" >Hello,{{$user}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('posts.create') }}">Create</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white bg-dark" href="{{ route('logout') }}" >LogOut</a>
          </li>
    </ul>
        @else 
<nav class="navbar border-bottom border-body justify-content-start gap-4 ms-4">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('image.png') }}" alt="Logo" height="60">
        </a>
        <a class="nav-link active color-white" aria-current="page" href="{{ route('blogs.index') }}">Home</a>
        <a class="nav-link" href="{{ route('login') }}">Login</a>
        <a class="nav-link" href="{{ route('register') }}">Register</a>
        
        <form class="d-flex" role="search" action="{{ route('blogs.index')}}" method="GET">
          <input class="form-control me-2" type="text" name="search" placeholder="Search" value="{{ request('search') }}" aria-label="Search"/>
          <button class="btn btn-outline-success" type="submit" >Search</button>
        </form>
</nav>
        @endif
    </div>
