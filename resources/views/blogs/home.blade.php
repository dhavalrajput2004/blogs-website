@extends('layouts.app')

@section('main')
    <x-header />
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Please Login</h5>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@if (isset($user))
    <div class="container">
        <div class="row  mb-4 d-flex align-items-center">
            <div class="col col-2">
                <div class="ratio ratio-1x1 rounded-circle overflow-hidden" style="width: 200px;">
                    <img src="{{ asset('storage/' . $user->profile_image) }}">
                </div>
            </div>
            <div class="col col-3">
                <h5 class="fw-bold"> {{ $user->name }} </h5>
                @if (Auth::check())
                    <button type="submit" class="btn btn-primary mb-2" id="follow-btn"> Follow

                    </button>
                @else
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> Follow
                    </button>
                @endif
            </div>
            <div class="col col-2">
                <div> 32 </div>
                <div class="fw-bold"> Followers </div>
            </div>
            <div class="col col-2">
                <div> 32 </div>
                <div class="fw-bold"> Following </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-8">
                <p class="fw-bold"> Bio : {{ $user->bio }} </p>
            </div>
            <div class="col-md-auto">
                Variable width content
            </div>
        </div>
    </div>
@endif

    <div class= "container mt-4">
        <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
        @if ($categories)
            <div class="mb-4">
                @foreach ($categories as $category)
                    <a href="{{ route('category.show', $category->category_name) }}"
                        class="{{ request()->is(route('category.show', $category->category_name)) ? 'btn btn-primary' : 'btn btn-outline-primary' }}">
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

    <script>
        $(document).ready(function() {

            $('#follow-btn').on('click', function() {
                
                $.ajax({
                    url: "route('handleFollow', ':')",
                    method: ,
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    }
                    success: function() {

                    },
                    error: ,
                })
            })

        })
    </script>
@endsection
