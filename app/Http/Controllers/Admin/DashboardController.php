<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $likes = DB::table('likes')
        ->join('posts','likes.likeable_id', '=', 'posts.id')
        ->where('posts.user_id', auth()->id())
        ->count();

        $comments = DB::table('likes')->join('comments','likes.likeable_id','=', 'comments.id')
        ->where('comments.user_id', auth()->id())
        ->count();

        $likesweek = DB::table('likes')->join('posts', 'likes.likeable_id', '=', 'posts.id')
        ->where('posts.user_id', auth()->id())
        ->where('likes.created_at','>=',now()->week())
        ->count();

        return view('admin.dashboard',compact('likes','comments','likesweek'));
    }

}
