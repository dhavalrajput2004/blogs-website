<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $post->load('comments');
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Post $post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            abort(403, 'not unauthorized to create comment on this post');
        }
        return view('comments.create', ['post' => $post, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'exists:comments,id'
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->parent_id = $request->parent_id;
        $comment->user_id = Auth::user()->id;
        $comment->save();
        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Comment $comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            abort(403, 'not unauthorized to edit comment on this post');
        }
        return view('comments.edit', ['post' => $post, 'comment' => $comment, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $comment = Comment::find($request->commentid);

        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            abort(403, 'not unauthorized to edit comment on this post');
        }
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment->comment = $request->comment;
        $comment->post_id = $request->postid;
        $comment->save();
        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if ($comment->user_id !== $user->id) {
            abort(403, 'not unauthorized to delete comment on this post');
        }
        $comment->delete();
        return redirect()->back()->with('success', 'comment deleted successfully.');
    }

    public function loadReplies()
    {
        $postId = request('post_id');
        $commentId = request('comment_id');
        $offset = request('offset');
        $hasnextPage = true;

        $query = Comment::where('post_id', $postId)
            ->where('parent_id', $commentId);
   
        $totalReplies = $query->count();

        $replies = $query->orderByDesc('created_at')
            ->offset($offset)->limit(1)->get();

        if(($offset +1) >= $totalReplies) {
            $hasnextPage = false;   
        }

        return response()->json([
            'next' => $hasnextPage,
            'html' => view('partials.replies', compact('replies','postId'))->render()
        ]);
    }
}
