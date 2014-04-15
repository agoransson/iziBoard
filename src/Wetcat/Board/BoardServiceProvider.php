<?php namespace Wetcat\Board;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Aliasloader;

class BoardServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	public function boot()
	{
		$this->package('wetcat/board');

    include __DIR__.'/../../routes.php';

    //AliasLoader::getInstance()->alias('iziBoard', 'Wetcat\Board\iziBoard');
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
