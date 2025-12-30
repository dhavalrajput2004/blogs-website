<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function updateLikes($id)
    {
        $userId = Auth::id();

        $post = Post::find($id);

        $liked = $post->likes()->where('user_id', $userId)->first();

        if ($liked) {

             $liked->delete();

             $post->decrement('likes');

             return response()->json(['status' => 'unliked' , 'likes' => $post->likes()->count()]);

        } else {

            $post->likes()->create(['user_id' => $userId]);

            $post->increment('likes');

            return response()->json(['status' => 'liked' , 'likes' => $post->likes()->count()]);
        }
    }

    public function updateCommentLikes($id)
    {
        $userId = Auth::id();

        $comment = Comment::find($id);

        $liked = $comment->likes()->where('user_id', $userId)->first();

        if ($liked) {

             $liked->delete();

             $comment->decrement('likes');

             return response()->json(['status' => 'unliked' , 'commentlikes' => $comment->likes()->count()]);

        } else {
            //   dd('not liked');
            $comment->likes()->create(['user_id' => $userId]);

            $comment->increment('likes');

            return response()->json(['status' => 'liked' , 'commentlikes' => $comment->likes()->count()]);
        }
    }
}            

