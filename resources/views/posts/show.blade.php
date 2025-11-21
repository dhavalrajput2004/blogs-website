@extends('layouts.app')
<div class="mx-auto p-2" style="width: 400px;">
    <img src="{{ asset("storage/".$post->image) }}" />
    <h1>{{ $post->title }}</h1>
    <p>Author: {{ $post->author }}</p>
    <p>{{ $post->body }}</p>

    <hr>
    <h3>Comments</h3>
    <a href="{{ route('comments.create', $post->id) }}" class="link-success">Add</a>
        <ul>
            @foreach($post->comments as $comment)
                <li>
                    {{ $comment->comment }}
                 <a href="{{ route('comments.edit', ['post'=>$post->id, 'comment' => $comment->id]) }}" class="btn btn-primary">Edit</a>

                <form action="{{ route('comments.destroy', ['post'=>$post->id, 'comment' => $comment->id]) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </li>
            @endforeach
        </ul>
        
    @if(session('success'))
    <script>
       alert('{{session('success')}}');
    </script>
    @endif

    <a href="{{ route('posts.index') }}" class="link-dark" >Back</a>
</div>
