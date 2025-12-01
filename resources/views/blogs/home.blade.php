@extends('layouts.app')
    <x-header />
@section('main')
<div class= "container mt-4">
     <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->

@if(count($posts) > 0)
<div class="row">
    @foreach($posts as $post)
        <div class="col-12 col-md-3 mb-4 ">
            <div class="card" style="width: 18rem;">
                 <img src="{{ asset("storage/".$post->image )}}" class="card-img-top" alt="post_image">

                 <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                     <a href="{{ route('blog.show', $post->id) }}" class="btn btn-primary">View</a>
                 </div>
             </div>
        </div>
    @endforeach

    {{ $posts->links() }}
</div>
@else
    <h1 class="text-center"> No Post Found </h1>
@endif
</div> 

@endsection
