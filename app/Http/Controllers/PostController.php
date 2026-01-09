<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
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
        $posts = Post::where('user_id', $user->id)->paginate(12);

        return view('posts.index', ['posts' => $posts, 'user' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {  
        $post->with('comments','tags');

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();

        return view('posts.create', ['user' => $user, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:20',
            'body' => 'required|string',
            'image' => 'image|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->category_id;

        $path = $request->file('image')->store('images', 'public');

        $post->image = $path;

        $post->save();

        $tags = explode(',', $request->tags);

        foreach ($tags as $tag) {

            $tag  = Tag::query()->firstOrCreate([
                'tag_name' => $tag,
            ]);

            $post->tags()->attach($tag->id);
        }

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
        $categories = Category::all();

        return view('posts.edit', ['post' => $post, 'user' => $user, 'categories' => $categories]);
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
            'body' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id'
        ]);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }

        $post->tags()->detach();

        $tags = explode(',', $request->tags);
 
        foreach ($tags as $tag) {

            $tag  = Tag::query()->firstOrCreate([
                'tag_name' => $tag,
            ]);

           $post->tags()->attach($tag->id);
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
            abort(403, 'unauthorized to view this post');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
