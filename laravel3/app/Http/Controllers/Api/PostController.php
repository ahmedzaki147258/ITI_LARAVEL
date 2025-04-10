<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostController extends Controller {
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $posts = Post::with('user')->latest()->paginate($limit, ['*'], 'page', $page);
        return $this->apiResponse([
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'posts' => PostResource::collection($posts)
        ], 'ok', ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = $request->user()->posts()->create($validated);
        $post->load('user');
        return $this->apiResponse(new PostResource($post), 'ok', ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response {
        $post->load('user');
        return $this->apiResponse(new PostResource($post), 'ok', ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): Response {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        $post->update($validated);
        $post->load('user');
        return $this->apiResponse(new PostResource($post), 'ok', ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response {
        $post->delete();
        return $this->apiResponse((object)[], 'post deleted successfully', ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
    * Display posts of the authenticated user
    */
    public function userPosts(Request $request): Response {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $posts = $request->user()->posts()->latest()->with('user')->paginate($limit, ['*'], 'page', $page);
        return $this->apiResponse([
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'posts' => PostResource::collection($posts)
        ], 'ok', ResponseAlias::HTTP_OK);
    }
}
