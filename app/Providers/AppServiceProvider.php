<?php

namespace App\Providers;

use App\Channel;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // These are used in navigation
        \View::composer('layouts._nav', function ($view) {
            $view->with('channels', Channel::all());
        });

        \View::composer('layouts._nav', function ($view) {
            $view->with('authors', User::where('id', '<', 7)->get());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
