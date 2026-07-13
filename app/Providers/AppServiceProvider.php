<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\AssignmentCreated::class,
            \App\Listeners\SendNewContentNotification::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\AnnouncementCreated::class,
            \App\Listeners\SendNewContentNotification::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\QuizCreated::class,
            \App\Listeners\SendNewContentNotification::class
        );
    }
}
