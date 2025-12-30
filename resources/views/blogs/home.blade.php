@extends('layouts.app')

@section('main')
    <x-header />
    <div class= "container mt-4">
        <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
        @if ($categories)
            <div class="mb-4">
                @foreach ($categories as $category)
                    <a href="{{ route('category.show', $category->category_name) }}"
                        class="btn {{ request()->is(route('category.show', $category->category_name)) ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $category->category_name }}</a>
                @endforeach
            </div>
        @endif

        @if (count($posts) > 0)
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-12 col-md-4 mb-4 ">
                        <div class="card border-dark" style="width: 21rem;">
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="post_image">

                            <div class="card-body">
                                <h5 class="card-text col-20 text-truncate">{{ $post->title }}</h5>
                                <a href="{{ route('blog.show', $post->id) }}" class="btn btn-primary">
                                    <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                </a>
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
