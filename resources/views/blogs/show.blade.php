  <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
  @extends('layouts.app')

  @section('main')
      <x-header />

      <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <label for="content">Edit Comment</label>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="{{ route('comments.update') }}">
                          @csrf @method('PUT')
                          <input type="hidden" id="postid" name="postid">
                          <input type="hidden" id="commentid" name="commentid">

                          <textarea name="comment" class="form-control" required></textarea>

                          <button id="update-comment-btn" type="submit" class="btn btn-primary mt-3">Edit</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <div class="mx-auto p-2 border-dark" style="width: 800px;">
          <h2>{{ $post->title }}</h2>

          <p>Author: <a class="link-dark" href="{{ route('blog.author', $post->user->id) }}">{{ $post->user->name }}</a>
          </p>
          <p>Tags:
              @foreach ($post->tags as $tag)
                  <a href="{{ route('tag.show', $tag->tag_name) }}" class="btn btn-primary">
                      {{ $tag->tag_name }}</a>
              @endforeach
          </p>

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
          <button id = "addComment" class="btn btn-primary">Add</button>

          <form id = "addCommentForm" style="display:none" method="POST"
              action="{{ route('comments.store', $post->id) }}">
              @csrf
              <label for="content">Comment</label>
              <textarea name="comment" class="form-control" required></textarea>

              <button type="submit" class="btn btn-primary mt-3">Save </button>
          </form>
          <ul>
              @foreach ($comments as $comment)
                  <li>
                      <b> {{ $comment->user->name }} </b>:
                      {{ $comment->comment }}
                      @auth
                          @if (Auth::id() === $comment->user_id)
                              <button type="button" data-bs-toggle="modal" data-bs-target="#editCommentModal"
                                  data-comment-id="{{ $comment->id }}" data-post-id = "{{ $post->id }}"
                                  data-bs-whatever="{{ $comment->comment }}" class="btn btn-primary btn-sm" id="edit-comment">
                                  <i class="fa fa-pencil" aria-hidden="true"></i>
                              </button>

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
                      @if (Auth::check())
                          <button type="submit" class="btn btn-primary mb-2 comment-like-btn"
                              id="comment-like-btn-{{ $comment->id }}" value="{{ $comment->id }}">
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

      @if (session('success'))
          <script>
              toastr.success('{{ session('success') }}')
          </script>
      @endif
      <script>
          var editCommentModal = document.getElementById('editCommentModal')

          editCommentModal.addEventListener('show.bs.modal', function(event) {

              var button = event.relatedTarget

              var data = button.getAttribute('data-bs-whatever')
              var comment = editCommentModal.querySelector('.modal-body textarea')

              comment.value = data

              var commentId = button.getAttribute('data-comment-id')
              var postId = button.getAttribute('data-post-id')

              var postParam = document.getElementById('postid')
              var commentParam = document.getElementById('commentid')
              postParam.value = postId
              commentParam.value = commentId
              console.log(postParam.value)
              console.log(commentParam.value)
          })

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
                          toggleIcon('#like-icon', res.status)
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

              function toggleIcon(id, status) {
                  $(id).removeClass((status == 'liked') ? 'fa fa-heart' : 'fa fa-heart-o')

                  $(id).addClass((status == 'liked') ? 'fa fa-heart-o' : 'fa fa-heart')
              }

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
