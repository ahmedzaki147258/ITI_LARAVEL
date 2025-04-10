<?php

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

Artisan::command('posts:delete', function () {
    $posts = Post::where('created_at', '<', now()->subYears(2))->get();
    foreach ($posts as $post) {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->comments()->delete();
        $post->delete();
    }
})->purpose('Delete posts older than 2 years')->dailyAt('00:00'); // ->everyMinute();
