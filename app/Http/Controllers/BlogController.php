<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function index()
    {
       // $name = 'Dhaval';
      //  Mail::to("mohmmad.husain@bytestechnolab.com")->send(new TestMail($name));

        $search = request('search');

        if ($search) {
            $posts = Post::search($search)->paginate(12);
        } else {
            $posts = Post::paginate(12);
        }


        return view('blogs.home', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        //$post->load('comments.user');

        $comments = $post->comments()->with('user')->orderBy('id')->paginate(3);

        return view('blogs.show', ['post' => $post, 'comments' => $comments]);
    }
}
