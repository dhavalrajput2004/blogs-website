<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Followers</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table-followers">
        <tbody>
            @if (count($followers) > 0)
                @foreach ($followers as $follower)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $follower->profile_image) }}" height="60"
                                class="rounded-circle mb-3">
                        </td>

                        <td>
                            <a class="link-dark" href="{{ route('blog.author', $follower->id) }}">
                                {{ $follower->name }} </a>
                        </td>

                        <td>
                            <button type='button' class="btn btn-primary follower-follow-btn"
                                id="follower-follow-btn-{{ $follower->id }}"
                                data-id="{{ $follower->id }}">
                                <div class="fol-btn-txt" data-id="{{ $follower->id }}">
                                    @if (auth()->user()->isFollowing($follower->id))
                                        UnFollow
                                    @else
                                        Follow Back
                                    @endif
                                </div>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <th class="text-center">There Is No Followers </th>
            @endif
        </tbody>
    </table>
</div>