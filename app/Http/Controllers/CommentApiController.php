<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Traits\ApiResponse;
use Throwable;
use Exception;

class CommentApiController extends Controller
{
    use ApiResponse;
    //
    public function index($postId) {
        try{
            $post = Post::find($postId);
            if(!$post) {
                throw new Exception("No post found", 404);
            } 

            if($post->comments()->count() == 0) {
                throw new Exception("No comments found", 404);
            } 

            $comments = $post->comments()->get();
            $data = CommentResource::collection($comments);
            return $this->successResponse($data, "comments fetched sussessfully");
        } 
        catch(Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(Request $request, $postId) {
        try{
            $post = Post::find($postId);
            if(!$post) {
                throw new Exception("No post found", 404);
            } 

            $validated = $request->validate([
                'comment' => 'required|string',
            ]);

            $comment = $post->comments()->create($validated);
            $data = new CommentResource($comment);
            return $this->successResponse($data, "comment added sussessfully",201);
        } 
        catch(Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, $postId, $commentId) {
        try{
            $post = Post::find($postId);
            if(!$post) {
                throw new Exception("No post found", 404);
            } 

            $comment = Comment::where([
               'id' => $commentId, 'post_id' => $postId
            ])->first();

           if(!$comment) {
                throw new Exception("comment not found", 404);
            } 

            $validated = $request->validate([
                'comment' => 'required|string'
            ]);

            $comment->update($validated);
            $data = new CommentResource($comment);
            return $this->successResponse($data, "comment updated sussessfully");
        } 
        catch(Throwable $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy($postId,$commentId) 
    {
        try {
            $post = Post::find($postId);
            if(!$post) {
                throw new Exception("No post found", 404);
            } 

            $comment = Comment::where([
                'id' => $commentId, 'post_id' => $postId
             ])->first();

            if(!$comment) {
                throw new Exception("comment not found", 404);
            }
            $comment->delete();

            return $this->successResponse(null, "comment deleted");
        } 
        catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

}
