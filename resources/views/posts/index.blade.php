@extends('layouts.app')

@section('main')
<div class= "container">
  <x-header :user="Auth::user()->name" />

@if($posts)
<div class="row">
@foreach($posts as $post)
<div class="col-12 col-md-3 mb-4 ">
    <div class="card" style="width: 18rem;">
    <img src="{{ asset("storage/".$post->image )}}" class="card-img-top" alt="post_image">

       <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <h5 class="card-title">{{ $post->author }}</h5>
            <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary">View</a>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display:inline;"
                onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
       </div>
   </div>
</div>
@endforeach
</div>
@else
 <h1 class="text-center"> No Post Found </h1>
 @endif

    @if(session('success'))
    <script>
       alert('{{session('success')}}');
    </script>
    @endif
</div>
@endsection
