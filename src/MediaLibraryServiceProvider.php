<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;
use League\Flysystem\Plugin\ListPaths;
use Stien\MediaLibrary\Filesystem\MediaFilesystem;

class MediaLibraryServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
		$this->setupMigrations();
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
	 * Setup the migrations needed.
	 *
	 * @return void
	 */
	protected function setupMigrations()
	{
		$source = realpath(__DIR__ . '/../migrations/');
		$this->publishes([$source => base_path('/database/migrations')]);
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
		$this->registerContentManager($app);
		$this->registerFilesystem($app);

		$app->singleton('bstien.library', function ($app)
		{
			return new Library($app['config'], $app['bstien.media.contentmanager']);
		});
	}

	public function registerContentManager(Application $app)
	{
		$app->singleton('bstien.media.contentmanager', function ($app)
		{
			return new ContentManager($app['config'], $app['bstien.media.filesystem']);
		});
	}

	/**
	 * Registers filesystem to 'bstien.media.filesystem'.
	 *
	 * @param Application $app
	 *
	 * @return void
	 */
	public function registerFilesystem(Application $app)
	{
		$app->singleton('bstien.media.filesystem', function ($app)
		{
			$filesystem = new Filesystem(new LocalAdapter($app['config']['medialibrary.library_path']));

			// Register plugins
			$filesystem->addPlugin(new ListFiles())->addPlugin(new ListPaths());

			return $filesystem;
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