<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create', ['users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'userId' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse((object)[], $validator->errors(), 404);
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'userId' => $request->userId
        ]);
        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show',[
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::with('user')->find($id);
        return view('posts.edit',[
            'post' => $post,
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'userId' => 'nullable|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse((object)[], $validator->errors(), 404);
        }

        $post = Post::find($id);
        if (!$post) {
            return $this->apiResponse((object) [], 'The post not found', 404);
        }
        $post->update($request->only(['title', 'description', 'userId']));
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->apiResponse((object) [], 'The post not found', 404);
        }
        $post->delete();
        return to_route('posts.index');
    }
}
