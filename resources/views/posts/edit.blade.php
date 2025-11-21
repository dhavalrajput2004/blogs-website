@extends('layouts.app')

@section('edit')
<div class="mx-auto p-2" style="width: 400px;">
    <!-- Well begun is half done. - Aristotle -->
    <h1>Edit Post</h1>
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" value="{{ $post->image }}" required>
            <td><img src="{{ asset("storage/".$post->image) }}" class="card-img-top" /></td>
            @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="author">Name</label>
            <input type="text" name="author" class="form-control" value="{{ $post->author }}" required>
            @error('author')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group" style = "padding: 10px">
            <label for="content">Content</label>
            <textarea name="body" class="form-control" required> {{$post->body}}</textarea>
            @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">update</button>
    </form>
</div>
@endsection