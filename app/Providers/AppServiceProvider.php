<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
	// URL::forceScheme('https');

        //if ($this->app->environment('production')) {
         //   $this->app['request']->server->set('HTTPS','on'); // this line
            //URL::forceScheme('https');

        //}
	if(env('APP_ENV') === 'production') {
		URL::forceScheme('https');
	}

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
