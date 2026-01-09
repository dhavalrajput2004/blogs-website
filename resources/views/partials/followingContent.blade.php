<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Followings</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table-following">
        <tbody>
            @if (count($followings) > 0)
                @foreach ($followings as $followee)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $followee->profile_image) }}" height="60"
                                class="rounded-circle mb-3">
                        </td>

                        <td>
                            <a class="link-dark" href="{{ route('blog.author', $followee->id) }}">
                                {{ $followee->name }} </a>
                        </td>

                        <td>
                            <button type='button' class="btn btn-primary follower-follow-btn"
                                id="follower-follow-btn-{{ $followee->id }}"
                                data-id="{{ $followee->id }}">
                                <div class="fol-btn-txt">
                                    @if (auth()->user()->isFollowing($followee->id))
                                        UnFollow
                                    @else
                                        Following
                                    @endif
                                </div>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <th class="text-center">There Is No Followings </th>
            @endif
        </tbody>
    </table>
</div>