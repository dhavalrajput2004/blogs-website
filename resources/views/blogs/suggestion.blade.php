   <div class="row">
        <div class="col-6">
            @foreach ($posts as $post)
                <div class="d-flex mb-2">
                    <img src="{{ asset('storage/' . $post->image) }}" class="image-fluid rounded me-2" alt="post_image"
                        style="width: 50px; height:auto;">
    
                    <div>
                        <a class= "text-decoration-none link-secondary" href="{{ route('blog.show', $post->id) }}">
                            <p class="col-4 text-truncate mb-0"> {{ $post->title }} </p>
                        </a>
                        <div class="me-2 lh-1">{{ $post->user->name }}</div>
                    </div>
    
                </div>
            @endforeach
        </div>
    
        <div class="col-6">
            @foreach ($authors as $author)
            <a class= "text-decoration-none link-secondary" href="{{ route('blog.author', $author->id) }}">
                <p> {{ $author->name }}</p>
            </a>
            @endforeach
      
            <div>
                @foreach ($comments as $comment)
                <a class= "text-decoration-none link-secondary" href="{{ route('blog.show', $comment->post_id )}}">
                    <p class= "col-8 text-truncate"> {{ $comment->comment }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>