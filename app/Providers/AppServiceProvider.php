<?php

namespace App\Providers;

use App\Channel;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view) {
            $channels = Cache::rememberForever('ch', function (){
                return Channel::select('slug')->get();
            });
          //  dd($channels);
            $view->with('channels', $channels);
        });
    }
}
