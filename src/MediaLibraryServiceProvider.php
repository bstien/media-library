<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MediaLibraryServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
	}

	/**
	 * Setup the config.
	 *
	 * @return void
	 */
	protected function setupConfig()
	{
		$source = realpath(__DIR__ . '/../config/medialibrary.php');
		$this->publishes([$source => config_path('medialibrary.php')]);
		$this->mergeConfigFrom($source, 'medialibrary');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerLibrary($this->app);
	}

	/**
	 * Registers the library class.
	 *
	 * @param Application $app
	 *
	 * @return void
	 */
	public function registerLibrary(Application $app)
	{
		$app->singleton('bstien.library', function ($app)
		{
			return new Library($app['config']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['bstien.library'];
	}
}