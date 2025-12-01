  <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    @extends('layouts.app')
    <x-header />
@section('main')
<div class="mx-auto p-2" style="width: 800px;">
    <img src="{{ asset('storage/' . $post->image) }}" />
    <h1>{{ $post->title }}</h1>
    <p>Author: {{ $post->author }}</p>
    <p>{!! $post->body !!}</p>

    <hr>

    <h3>Comments</h3>

    <ul>
        @foreach($comments as $comment)
            <li>
      <b> {{ $comment->user->name }} </b>: 
                {{ $comment->comment }}
            </li>
        @endforeach
        {{ $comments->links() }}
    </ul>

    <a href="{{ route('blogs.index') }}" class="link-dark">Back</a>
</div>
@endsection
