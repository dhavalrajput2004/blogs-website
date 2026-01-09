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
        <!-- Modal -->
        <div class="modal fade" id="followModal" tabindex="-1" aria-labelledby="followModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="follower-data"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="following-data"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row  mb-4 d-flex align-items-center">
                <div class="col col-2">
                    <div class="ratio ratio-1x1 rounded-circle overflow-hidden" style="width: 200px;">
                        <img src="{{ asset('storage/' . $user->profile_image) }}">
                    </div>
                </div>
                <div class="col col-3">
                    <h5 class="fw-bold"> {{ $user->name }} </h5>
                    @if (auth()->id() != $user->id)
                        @auth
                            <button type="submit" id="follow-btn"
                                class="{{ auth()->user()->isFollowing($user->id) ? 'btn btn-primary' : 'btn btn-outline-primary' }}">
                                <div id="btn-text">
                                    @if (auth()->user()->isFollowing($user->id))
                                        Following
                                    @else
                                        Follow
                                    @endif
                                </div>
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"> Follow
                            </button>
                        @endauth
                    @endif
                </div>
                <div class="col col-2">
                    <div id= "follower-count" data-bs-target="#followModal">
                        {{ $user->followers()->count() }} </div>
                    <div class="fw-bold"> Followers </div>
                </div>
                <div class="col col-2">
                    <div id= "follwee-count" data-bs-target="#followingModal">
                        {{ $user->following()->count() }} </div>
                    <div class="fw-bold"> Following </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-8">
                    <p class="fw-bold"> Bio : {{ $user->bio }} </p>
                </div>
            </div>
        </div>
    @endif

    <div class= "container mt-4">
        <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
        @if ($categories)
            <div class="mb-4" id="category-nav">
                @foreach ($categories as $category)
                    <a id = "category-{{ $category->id }}" href="{{ route('category.show', $category->category_name) }}"
                        class="btn btn-outline-primary">
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

    @if (isset($user))
        <script>
            $(document).ready(function() {

                var userId = {{ $user->id }}
                const authId = {{ auth()->id() }}

                $('#follow-btn').on('click', function() {
                    console.log(userId)
                    $.ajax({
                        url: "{{ route('handleFollow', ':user') }}".replace(':user', userId),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            console.log(res)
                            $('#follower-count').text(res.followers)
                            $('#follwee-count').text(res.followings)
                            toggleIcon('#follow-btn', res.status)
                            toggleText('#btn-text', res.status)
                        },
                        error: function(status, error) {
                            console.error("An error occurred: " + status + " " + error)
                        },
                    })
                })

                $('#follower-count').on('click', function() {

                    if (authId == userId) {
                        $('#followModal').modal('show');

                        $.ajax({
                            url: "{{ route('getFollowers') }}",
                            method: 'GET',
                            dataType: 'html',
                            success: function(res) {
                                $('#follower-data').html(res)
                            },
                            error: function(status, error) {
                                console.error("An error occurred: " + status + " " + error)
                            },
                        })
                    }
                })

                $('#follwee-count').on('click', function() {

                    if (authId == userId) {
                        $('#followingModal').modal('show');

                        $.ajax({
                            url: "{{ route('getFollowing') }}",
                            method: 'GET',
                            dataType: 'html',
                            success: function(res) {
                                $('#following-data').html(res)
                            },
                            error: function(status, error) {
                                console.error("An error occurred: " + status + " " + error)
                            },
                        })
                    }
                })

                $(document).on('click', '.follower-follow-btn', function() {
                    var followerId = $(this).data('id')
                    console.log(followerId)

                    $.ajax({
                        url: "{{ route('handleAdminFollow', ':user') }}".replace(':user', followerId),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            console.log(res, followerId)
                            $('#follower-count').text(res.followers)
                            $('#follwee-count').text(res.followings)
                            toggleFolText("#follower-follow-btn-" + followerId, res.status)
                        },
                        error: function(status, error) {
                            console.error("An error occurred: " + status + " " + error)
                        },
                    })
                })

                function toggleIcon(id, status) {
                    $(id).removeClass((status == 'followed') ? 'btn btn-outline-primary' : 'btn btn-primary')

                    $(id).addClass((status == 'followed') ? 'btn btn-primary' : 'btn btn-outline-primary')
                }

                function toggleText(id, status) {
                    $(id).text((status == 'followed') ? 'Following' : 'Follow')
                }

                function toggleFolText(id, status) {
                    $(id).text((status == 'followed') ? 'UnFollow' : 'Follow Back')
                }
            })
        </script>
    @endif

    <script>
        const navLinks = document.querySelectorAll('#category-nav a');
        navLinks.forEach(link => {
            
            if (link.href === window.location.href) {
                $(link).removeClass('btn btn-outline-primary'); 
                $(link).addClass('btn btn-primary'); 
            }
        })
    </script>
@endsection
