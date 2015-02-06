<?php namespace Owlgrin\Guard;

use Illuminate\Support\ServiceProvider;

class GuardServiceProvider extends ServiceProvider {

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
		$this->package('owlgrin/guard');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// binding the command to generate the tables
		$this->app->bindShared('command.guard.table', function($app)
		{
			return new \Owlgrin\Guard\Commands\GuardTableCommand;
		});

		//	telling laravel what we are providing to the app using the package
		$this->commands('command.guard.table');


		$this->app->bind('Owlgrin\Guard\Storage\Storage', 'Owlgrin\Guard\Storage\DbStorage');

		$this->app->singleton('guard', 'Owlgrin\Guard\Guard');
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
