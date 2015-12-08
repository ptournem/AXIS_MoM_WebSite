<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class LogsServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
	//
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
	App::bind('Logs', function() {
	    return new \App\Classes\Logs;
	});
    }

}
