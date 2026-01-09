<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.editprofile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'bio' => 'required|string',
            'name' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;

        if ($request->hasFile('image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('image')->store('images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('posts.index')->with('success', 'Profile updated successfully.');
    }

    public function getFollowing()
    {
        $followings = auth()->user()->following;

        return view('partials.followingContent', compact('followings'));
    }

    public function getFollowers()
    {
        $followers = auth()->user()->followers;

        return view('partials.followerContent', compact('followers'));
    }

    public function handleFollow($authorId)
    {
        $user = User::find(auth()->id());
        $author = User::find($authorId);

        $following = $user->following()->where('followee_id', $authorId)->first();

        if ($following) {

            $author->followers()->detach($user->id);

            return response()->json([
                'status' => 'unfollowed', 
                'followers' => $author->followers()->count(), 
                'followings' => $author->following()->count()
            ]);
        } else {

            $author->followers()->attach($user->id);

            return response()->json([
                'status' => 'followed',
                'followers' => $author->followers()->count(),
                'followings' => $author->following()->count()
            ]);
        }
    }

    public function handleAdminFollow($authorId)
    {
        $user = User::find(auth()->id());
        $author = User::find($authorId);

        $following = $user->following()->where('followee_id', $authorId)->first();

        if ($following) {

            $author->followers()->detach($user->id);

            return response()->json([
                'status' => 'unfollowed', 
                'followers' => $user->followers()->count(), 
                'followings' => $user->following()->count()
            ]);
        } else {

            $author->followers()->attach($user->id);

            return response()->json([
                'status' => 'followed',
                'followers' => $user->followers()->count(),
                'followings' => $user->following()->count()
            ]);
        }
    }
}
