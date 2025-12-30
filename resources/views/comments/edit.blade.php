@extends('layouts.app')

@section('main')
    <x-header :user="$user->name" />

    <form method="POST" action="{{ route('comments.update', ['post' => $post->id, 'comment' => $comment->id]) }}">
        @csrf @method('PUT')
        <label for="content">Comment</label>
        <textarea name="comment" class="form-control" required>{{ $comment->comment }}
            </textarea>

        <button type="submit" class="btn btn-primary mt-3">Edit</button>
    </form>
@endsection
