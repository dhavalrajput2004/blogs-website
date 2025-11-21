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
        if($post->user_id !== $user->id) {
            abort(403,'not unauthorized to create comment on this post');
        }
        return view('comments.create', ['post' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Post $post)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $post->id;
        $comment->user_id = Auth::user()->id;
        //dd($post);
        $comment->save();
        return redirect()->route('post.show', $post->id)->with('success', 'Comment added successfully.');
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
        if($post->user_id !== $user->id  || $comment->user_id !== $user->id) {
            abort(403,'not unauthorized to edit comment on this post');
        }
        return view('comments.edit',['post' => $post, 'comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $user = Auth::user();
        if($post->user_id !== $user->id  || $comment->user_id !== $user->id) {
            abort(403,'not unauthorized to edit comment on this post');
        }
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment->comment = $request->comment;
        $comment->post_id = $post->id;
        $comment->save();
        return redirect()->route('post.show', $post->id)->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $user = Auth::user();
        if($post->user_id !== $user->id  || $comment->user_id !== $user->id) {
            abort(403,'not unauthorized to delete comment on this post');
        }
        $comment->delete();
        return redirect()->route('post.show', $post->id)->with('success', 'comment deleted successfully.');
    }
}
