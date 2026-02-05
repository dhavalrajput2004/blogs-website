
    @foreach ($replies as $reply)
        <li>
            <img src="{{ asset('storage/' . $reply->user->profile_image) }}"
                height="50" class="rounded-circle ">
            <b> {{ $reply->user->name }} </b>: {{ $reply->created_at->diffForHumans() }}
            <p> {{ $reply->comment }} </p>

            @auth
                @if (Auth::id() === $reply->user_id)
                    <button type="button" data-bs-toggle="modal"
                        data-bs-target="#editCommentModal"
                        data-comment-id="{{ $reply->id }}"
                        data-post-id = "{{ $postId }}"
                        data-bs-whatever="{{ $reply->comment }}"
                        class="p-0 btn-sm border-0 text-primary" id="edit-comment">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>

                    <form
                        action="{{ route('comments.destroy', ['post' => $postId, 'comment' => $reply->id]) }}"
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
