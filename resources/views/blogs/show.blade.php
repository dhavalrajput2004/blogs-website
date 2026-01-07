  <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
  @extends('layouts.app')

  @section('main')
      <x-header />
      <div class="mx-auto p-2 border-dark" style="width: 800px;">
          <h2>{{ $post->title }}</h2>

          <p>Author: <a class="link-dark" href="{{ route('blog.author', $post->user->id) }}" >{{ $post->user->name }}</a> </p>
          <p>Tags:
            @foreach ($post->tags as $tag)
            <a href="{{ route('tag.show', $tag->tag_name) }}" class="btn btn-primary">
                {{ $tag->tag_name }}</a>
            @endforeach </p>

          <p>Category: {{ $post->category_id == null ? '' : $post->category->category_name }}</p>

          Likes: <span id= "like-count">{{ $post->likes()->count() }}</span>

          @if (Auth::check())
              <button type="submit" class="btn btn-primary mb-2" id="like-btn">
                  <i class="{{ $post->userLiked(auth()->id()) ? 'fa fa-heart-o' : 'fa fa-heart' }}" id = "like-icon"
                      aria-hidden="true"></i>
              </button>
          @else
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="fa fa-heart-o" aria-hidden="true"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
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
          @endif

          <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top rounded" />
          <p>{!! $post->body !!}</p>

          <h3>Comments</h3>

          <ul>
              @foreach ($comments as $comment)
                  <li>
                      <b> {{ $comment->user->name }} </b>:
                      {{ $comment->comment }}

                      @if (Auth::check())
                          <button type="submit" class="btn btn-primary mb-2 comment-like-btn"  id="comment-like-btn-{{ $comment->id }}"
                              value="{{ $comment->id }}">
                              <i class="{{ $comment->userLiked(auth()->id()) ? 'fa fa-heart-o' : 'fa fa-heart' }}"
                                  id = "comment-like-icon-{{ $comment->id }}" aria-hidden="true"></i>
                          </button>
                      @else
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                              data-bs-target="#exampleModal">
                              <i class="fa fa-heart-o" aria-hidden="true"></i>
                          </button>
                      @endif

                      <span id= "comment-like-count-{{ $comment->id }}">{{ $comment->likes()->count() }}</span>
                  </li>
              @endforeach
              {{ $comments->links() }}
          </ul>

          <a href="{{ route('blogs.index') }}" class="link-dark">Back</a>
      </div>

      <script>
          $(document).ready(function() {

              var postId = {{ $post->id }};

              $('#like-btn').on('click', function() {

                  $.ajax({
                      url: "{{ route('post.likes', ':post') }}".replace(':post', postId),
                      method: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(res) {
                          console.log(res)
                          $('#like-count').text(res.likes)

                          var icon = '#like-icon';
                          toggleIcon(icon, res.status)
                      },
                      error: function(status, error) {
                          console.error("An error occurred: " + status + " " + error)
                      }
                  })
              })

              $('.comment-like-btn').on('click', function() {

                  var commentId = $(this).attr('value');
                  console.log(commentId)

                  $.ajax({
                      url: "{{ route('comment.likes', ':comment') }}".replace(':comment', commentId),
                      method: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      success: function(res) {
                          console.log(res)
                          $('#comment-like-count-' + commentId).text(res.commentlikes)

                          var icon = '#comment-like-icon-' + commentId;
                          toggleIcon(icon, res.status)
                      },
                      error: function(status, error) {
                          console.error("An error occurred: " + status + " " + error)
                      }
                  })
              })

              function toggleIcon(id, status) 
              {
                $(id).removeClass((status == 'liked') ? 'fa fa-heart' :'fa fa-heart-o')

                $(id).addClass((status == 'liked') ? 'fa fa-heart-o' :'fa fa-heart')
              }
          })
      </script>
  @endsection
