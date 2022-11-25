<?php

namespace BreakTravel\ArtisanServeXdebug;

use Illuminate\Console\Application as Artisan;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $commands = [Command::class];
            Artisan::starting(function ($artisan) use ($commands) {
                $artisan->resolveCommands($commands);
            });
        }
    }
}
