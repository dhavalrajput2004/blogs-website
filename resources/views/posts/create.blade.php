@extends('layouts.app')
    <!-- Well begun is half done. - Aristotle -->
    <x-header :user="Auth::user()->name"/>
    @section('main')
<div class="mx-auto p-2" style="width: 400px;">
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" required>
            @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="author">Name</label>
            <input type="text"  name="author" value="{{ old('author') }}" class="form-control" required>
            @error('author')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="body">Content</label>
            <textarea id="summernote" name="body">{{ old('body') }}</textarea>
            @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
  @endsection