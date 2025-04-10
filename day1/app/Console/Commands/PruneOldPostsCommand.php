<?php

namespace App\Console\Commands;

use App\Jobs\PruneOldPostsJob;
use App\Models\Post;
use Illuminate\Console\Command;

class PruneOldPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedPosts = Post::where('created_at', '<', now()->subYear(2))->delete();
        $this->info($deletedPosts .' old posts have been cleaned up!');
    }
}
