@extends('layouts.app')

@section('main')
    <x-header :user="Auth::user()->name" />

    <div class="mx-auto p-2" style="width: 800px;">
        <h1>{{ $post->title }}</h1>

        <p>Tags:
            @foreach ($post->tags as $tag)
                <a href="{{ route('tag.show', $tag->tag_name) }}" class="btn btn-primary">
                    {{ $tag->tag_name }}</a>
            @endforeach
        </p>

        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" />
        <p>Author:{{ $post->user->name }}</p>
        <p>Category: {{ $post->category_id == null ? '' : $post->category->category_name }}</p>
        <p id = "content-display-area">{!! $post->body !!}</p>

        <hr>

        <h3>Comments</h3>
        <button id = "addComment" class="btn btn-primary">Add</button>

        <form id = "addCommentForm" style="display:none" method="POST" action="{{ route('comments.store') }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id}}">
            <label for="content">Comment</label>
            <textarea name="comment" class="form-control" required></textarea>

            <button type="submit" class="btn btn-primary mt-3">Save </button>
        </form>
        <ul>
            @foreach ($post->comments as $comment)
                <div class="mb-2 align-">
                    {{ $comment->comment }}
                    @auth
                        @if (Auth::id() === $post->user_id && Auth::id() === $comment->user_id)
                            <a href="{{ route('comments.edit', ['post' => $post->id, 'comment' => $comment->id]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>

                            <form action="{{ route('comments.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}"
                                method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @endforeach
        </ul>

        @if (session('success'))
            <script>
                toastr.success('{{ session('success') }}')
            </script>
        @endif

        <a href="{{ url()->previous() }}" class="link-dark">Back</a>
    </div>

    <script>
        $(document).ready(function() {
            $('#addComment').on('click', function() {
                showForm();
            })

            function showForm() {
                var form = document.getElementById("addCommentForm");
                if (form.style.display === "block") {
                    form.style.display = "none"
                } else {
                    form.style.display = "block"
                }
            }
        })
    </script>
@endsection
