<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class DeleteOldPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete posts older than 2 years';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::where('created_at', '<', now()->subYears(2))->delete();
        $this->info('Successfully deleted posts older than 2 years.');
    }
}
