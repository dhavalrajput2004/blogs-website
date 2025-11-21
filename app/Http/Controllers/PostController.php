<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();
        return view('posts.index', ['posts' => $posts, 'user' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            abort(403, 'not unauthorized to view this post');
        }
        $post->load('comments');
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:20',
            'author' => 'required|string',
            'body' => 'required|string',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->author = $request->author;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;

        $path = $request->file('image')->store('images', 'public');

        // $path = Storage::disk('public')->put('images', $request->file('image'));

        $post->image = $path;

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            abort(403, 'not unauthorized to update this post');
        }
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            abort(403, 'not unauthorized to view this post');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'body' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        $post->title = $request->title;
        $post->author = $request->author;
        $post->body = $request->body;

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user = Auth::user();
        if ($post->user_id !== $user->id) {
            abort(403, 'not unauthorized to view this post');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
