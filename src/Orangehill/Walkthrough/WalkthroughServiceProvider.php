<?php namespace Orangehill\Walkthrough;

use Illuminate\Support\ServiceProvider;

class WalkthroughServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('orangehill/walkthrough');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['walkthrough'] = $this->app->share(function($app)
		{
			return new Walkthrough;
		});
		$this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('Walkthrough', 'Orangehill\Walkthrough\Facades\Walkthrough');
		});
		$this->app['command.walkthrough'] = $this->app->share(function($app)
		{
			return new WalkthroughCommand;
		});
		$this->commands('command.walkthrough');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
