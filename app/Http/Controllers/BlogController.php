<?php

namespace App\Http\Controllers;

use App\Jobs\UserJob;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class BlogController extends Controller
{
    public function index()
    {
        $search = request('search');
        $categories = Category::select('category_name')->get();

        if ($search) {
            $posts = Post::search($search)->paginate(12);
        } else {
            $posts = Post::paginate(12);
        }

        return view('blogs.home', ['posts' => $posts, 'categories' => $categories]);
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->with('user')->orderBy('id')->paginate(3);

        $post->with('comments', 'tags','likes');

        return view('blogs.show', ['post' => $post, 'comments' => $comments]);
    }

    public function getSuggestions()
    {
        $search = request('search');

        $posts = Post::search($search)->with('user')->select('id', 'title', 'image', 'user_id')->take(10)->get();
        
        $authors = User::query()->select('name', 'id')->where('name', 'like', '%' . $search . '%')->take(5)->get();

        $comments = Comment::query()->select('comment','post_id')->where('comment', 'like', '%' . $search . '%')->take(5)->get();

        return view('blogs.suggestion', ['posts' => $posts, 'authors' => $authors, 'comments' => $comments]);
    }

    public function listByAuthor($id)
    {
        $categories = Category::select('category_name')->get();

        $posts = Post::where('user_id', $id)->paginate(12);

        return view('blogs.home', ['posts' => $posts, 'categories' => $categories]);
    }
}
