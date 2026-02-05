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
          <h6> {{ $post->created_at->diffForHumans() }} </h6>
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

          <form id = "addCommentForm" style="display:none" method="POST" action="{{ route('comments.store') }}">
              @csrf
              <input type="hidden" name="post_id" value="{{ $post->id }}">

              <label for="content">Comment</label>
              <textarea name="comment" class="form-control" required></textarea>

              <button type="submit" class="btn btn-primary mt-3">Save </button>
          </form>
          <ul class="list-unstyled">
              @foreach ($comments as $comment)
                  <li class="flex gap-1 flex-col pb-2" style="border-bottom: 1px solid">
                      <img src="{{ asset('storage/' . $comment->user->profile_image) }}" height="50"
                          class="rounded-circle mb-3">

                      <b> {{ $comment->user->name }} </b>: {{ $comment->created_at->diffForHumans() }}
                      <p> {{ $comment->comment }} </p>
                      @auth
                          @if (Auth::id() === $comment->user_id)
                              <button type="button" data-bs-toggle="modal" data-bs-target="#editCommentModal"
                                  data-comment-id="{{ $comment->id }}" data-post-id = "{{ $post->id }}"
                                  data-bs-whatever="{{ $comment->comment }}" class="p-0 btn-sm border-0 text-primary"
                                  id="edit-comment">
                                  <i class="fa fa-pencil" aria-hidden="true"></i>
                              </button>

                              <form action="{{ route('comments.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="p-0 border-0 text-danger">
                                      <i class="fa fa-trash-o" aria-hidden="true"></i>
                                  </button>
                              </form>
                          @endif
                      @endauth
                      @if (Auth::check())
                          <button type="submit" class="mb-2 p-0 border-0 text-primary comment-like-btn"
                              id="comment-like-btn-{{ $comment->id }}" value="{{ $comment->id }}">
                              <i class="{{ $comment->userLiked(auth()->id()) ? 'fa fa-heart' : 'fa fa-heart-o' }}"
                                  id = "comment-like-icon-{{ $comment->id }}" aria-hidden="true"></i>
                          </button>
                      @else
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                              data-bs-target="#exampleModal">
                              <i class="fa fa-heart-o" aria-hidden="true"></i>
                          </button>
                      @endif

                      <span id= "comment-like-count-{{ $comment->id }}">{{ $comment->likes()->count() }}</span>

                      <a href="#" onclick="showReplyForm({{ $comment->id }})" id="addReply-{{ $comment->id }}">
                          Reply </a>

                      <form class="replyForm" id = "addReplyForm-{{ $comment->id }}" style="display:none"
                          method="POST" action="{{ route('comments.store') }}">
                          @csrf
                          <input type="hidden" name="post_id" value="{{ $post->id }}">
                          <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                          <label for="content">Comment</label>
                          <textarea name="comment" class="form-control" required></textarea>

                          <button type="submit" class="btn btn-primary mt-3">Save </button>
                      </form>

                      @if ($comment->replies->count() > 0)
                          <div class="d-flex mx-4">
                              <ul id="list-replies" class="list-unstyled">
                                  @foreach ($comment->replies as $reply)
                                      <li>
                                          <img src="{{ asset('storage/' . $reply->user->profile_image) }}" height="50"
                                              class="rounded-circle ">
                                          <b> {{ $reply->user->name }} </b>: {{ $reply->created_at->diffForHumans() }}
                                          <p> {{ $reply->comment }} </p>

                                          @auth
                                              @if (Auth::id() === $reply->user_id)
                                                  <button type="button" data-bs-toggle="modal"
                                                      data-bs-target="#editCommentModal"
                                                      data-comment-id="{{ $reply->id }}"
                                                      data-post-id = "{{ $post->id }}"
                                                      data-bs-whatever="{{ $reply->comment }}"
                                                      class="p-0 btn-sm border-0 text-primary" id="edit-comment">
                                                      <i class="fa fa-pencil" aria-hidden="true"></i>
                                                  </button>

                                                  <form
                                                      action="{{ route('comments.destroy', ['post' => $post->id, 'comment' => $reply->id]) }}"
                                                      method="POST" style="display:inline;"
                                                      onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="p-0 border-0 text-danger ">
                                                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                      </button>
                                                  </form>
                                              @endif
                                          @endauth
                                      </li>
                                  @endforeach
                              </ul>
                          </div>
                          <div id="reply-box" class="d-flex mx-4"> </div>   
                          {{-- @if ($comment->replies()->count() > 1) --}}
                          <a href="#" class="load-replies" id="load-replies-{{ $comment->id }}"
                              value="{{ $comment->id }}"> Load More </a>
                          {{-- @endif --}}
                      @endif
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
          function showReplyForm(id) {
              event.preventDefault();
              var replyBtn = document.getElementById('addReply-' + id);
              var replyForm = document.getElementById('addReplyForm-' + id);

              if (replyForm.style.display === "block") {
                  replyForm.style.display = "none"
              } else {
                  replyForm.style.display = "block"
              }
          }

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

              var offset = 0

              $('.load-replies').on('click', function() {
                  event.preventDefault();
                  offset = offset + 1
                  console.log(offset)
                  var loadbtnId = $(this).attr('value')
                  var btn = $(this)

                  $.ajax({
                      url: "{{ route('loadReplies') }}",
                      method: 'GET',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      data: {
                          "post_id": postId,
                          "comment_id": loadbtnId,
                          "offset": offset
                      },
                      success: function(res) {

                          if (res.next === false) {
                              console.log(res.next)
                              btn.hide()
                          }
                          $("#list-replies").append(res.html);
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
                  $(id).removeClass((status == 'liked') ? 'fa fa-heart-o' : 'fa fa-heart')

                  $(id).addClass((status == 'liked') ? 'fa fa-heart' : 'fa fa-heart-o')
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
