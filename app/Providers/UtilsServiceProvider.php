<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class UtilsServiceProvider extends ServiceProvider{
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
	App::bind('Utils', function() {
	    return new \App\Classes\Utils;
	});
    }
}
