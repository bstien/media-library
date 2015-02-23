<?php
namespace Stien\MediaLibrary;

use Illuminate\Support\ServiceProvider;

class MediaLibraryServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('Stien\MediaLibrary\Library', function($app){
			return new Library();
		});
	}

	public function provides(){}
}