<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request, Post $post): Response|RedirectResponse {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse((object)[], $validator->errors(), 404);
        }

        Comment::create([
            'body' => $request->body,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class
        ]);
        return to_route('posts.show', $post->id);
    }

    public function destroy(Comment $comment): RedirectResponse {
        $comment->delete();
        return to_route('posts.show', $comment->commentable_id);
    }
}
