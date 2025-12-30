<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    use ApiResponse;
    //
    public function index()
    {
        try{   
           $posts = Post::with('comments')->get();
            if($posts->count() == 0) {
                throw new Exception("No post found", 404);
            } 
            $data = PostResource::collection($posts);
            return $this->successResponse($data, "data fetched sussessfully");
        } catch(Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
                'image' => 'image|mimes:png,jpg,jpeg'
            ]);

            if($request->hasFile('image')) {
                $path = $request->file('image')->store('images','public');
                $validated['image'] = $path;
            }

            $post = Post::create($validated);
            $data = new PostResource($post);

            return $this->successResponse($data, "posts created sussessfully",201);
        } 
        catch(Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::with('comments')->findOrFail($id);
            $data = new PostResource($post);
            return $this->successResponse($data, "post fetched");
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
         
            $validated = $request->validate([
                'title'  => 'string',
                'body'   => 'string',
                'image'  => 'image|mimes:png,jpg,jpeg'
            ]);
    
            $post = Post::find($id);
    
            if (!$post) {
                throw new Exception("This post does not exist", 404);
            }

            if ($request->hasFile('image')) {
    
                if ($post->image && Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
    
                $path = $request->file('image')->store('images', 'public');
                $validated['image'] = $path;
            }

            $post->update($validated);
            $data = new PostResource($post);
            return $this->successResponse($data, "Post updated");
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }
    

    public function destroy($id) 
    {
        try {
            $post = Post::find($id);
            if(!$post) {
                throw new Exception("No post found", 404);
            } 
            if($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
            return $this->successResponse(null, "posts deleted");
        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }
    
}
