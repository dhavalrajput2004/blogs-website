@extends('layouts.app')

@section('main')
    <link rel="stylesheet" href="{{ asset('js/inputTags.css') }}">
    <x-header :user="Auth::user()->name" />

    <div class="mx-auto p-2" style="width: 800px;">
        <h1>Edit Post</h1>
        <form method="POST" onkeydown="if(event.key==='Enter'){event.preventDefault();}"
            action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Tags --}}
            <div class="form-group">
                <label for="title">Tags </label>
                <input type="text" name="tags" class="form-control" id="tags" 
                value="{{ implode(',', $post->tags->pluck('tag_name')->toArray()) }}" />
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" value="{{ $post->image }}">
                <td><img src="{{ asset('storage/' . $post->image) }}" style="width: 400px;" class="card-img-top" /></td>
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
                <label for="Category">Category</label>

                <select class="form-select" name ="category_id" required>
                    <option selected>select category</option>
                    @foreach ($categories as $category)
                        <option @selected($post->category_id != null && $category->id == $post->category->id) value="{{ $category->id }}">{{ $category->category_name }}
                        </option>
                        {{-- <option {{ $category->id == $post->category->id ? 'selected' : '' }}  value="{{ $category->id }}">{{ $category->category_name }}</option> --}}
                    @endforeach
                </select>

                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style = "padding: 10px">
                <label for="content">Content</label>
                <textarea id="summernote" name="body" value="{{ old('body') }}">{{ $post->body }}</textarea>
                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">update</button>
        </form>
    </div>

    <script>
        $('#tags').inputTags({
            autocomplete: {
                values: ['tags','jQuery','plugin','new','trend'],
                only: false
            },
        });

    </script>
@endsection
