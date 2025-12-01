@extends('layouts.app')
<x-header :user="$user->name"/>
@section('main')
<form method="POST" action="{{ route('comments.store', $post->id) }}">
@csrf
            <label for="content">Comment</label>
            <textarea name="comment" class="form-control" required></textarea>

        <button type="submit" class="btn btn-primary mt-3">Add </button>
</form>
@endsection