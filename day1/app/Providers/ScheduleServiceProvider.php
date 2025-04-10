<?php

namespace App\Providers;

use App\Jobs\PruneOldPostsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            // For production: Schedule PruneOldPostsJob to run daily at midnight
            // $schedule->job(new PruneOldPostsJob)->dailyAt('00:00');

            // For testing: Run every minute so we can confirm it works
            $schedule->job(new PruneOldPostsJob)->everyMinute();
        });
    }
}
