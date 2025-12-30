@extends('layouts.app')
<!-- Well begun is half done. - Aristotle -->
@section('main')
    <link rel="stylesheet" href="{{ asset('js/inputTags.css') }}">
    <x-header :user="Auth::user()->name" />
    <div class="mx-auto p-2" style="width: 800px;">
        <h1>Create Post</h1>

        <form method="POST" onkeydown="if(event.key==='Enter'){event.preventDefault();}" action="{{ route('posts.store') }}"
            enctype="multipart/form-data">
            @csrf

            {{-- Tags --}}
            <div class="form-group">
                <label for="title">Tags</label>
                <input type="text" name="tags" class="form-control" id="tags" />
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
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
                <label for="Category">Category</label>

                <select class="form-select" name ="category_id" required>
                    <option selected>select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>

                @error('category_name')
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

    <script>
        $('#tags').inputTags({
            autocomplete: {
                values: ['jQuery', 'tags', 'plugin', 'Javascript'],
                only: false
            },
        });

    </script>
@endsection
