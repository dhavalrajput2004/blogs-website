@extends('layouts.app')

@section('main')
    @if (Auth::user())
        <x-header :user="Auth::user()->name" />
    @endif

    @if ($posts)
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-12 col-md-3 mb-4 ">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="post_image">

                        <div class="card-body">
                            <h5 class="card-title col-20 text-truncate">{{ $post->title }}</h5>
                            <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary">
                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $posts->links() }}
        </div>
    @else
        <h1 class="text-center"> No Post Found </h1>
    @endif

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif
    </div>
@endsection
