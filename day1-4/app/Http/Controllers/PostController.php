<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PostController extends Controller {
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): object {
        // $page = $request->query('page', 1);
        // $posts = Post::with('user')->paginate(17, ['*'], 'page', $page);
        // return view('posts.index', ['totalPages' => $posts->lastPage(), 'currentPage' => $posts->currentPage(), 'posts' => $posts->items()]);
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user')->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): object {
        return view('posts.create', ['users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): object {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'userId' => $request->userId,
            'image' => $imagePath
        ]);
        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): object {
        $post->load('comments');
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): object {
        $post = Post::with('user')->find($id);
        return view('posts.edit', [
            'post' => $post,
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id): object {
        $post = Post::find($id);
        if (!$post) {
            return $this->apiResponse((object)[], 'The post not found', 404);
        }
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update($request->only(['title', 'description', 'userId']));
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): object {
        $post = Post::find($id);
        if (!$post) {
            return $this->apiResponse((object)[], 'The post not found', 404);
        }
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->comments()->delete();
        $post->delete();
        return to_route('posts.index');
    }
}
