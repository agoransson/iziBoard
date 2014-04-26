<?php namespace Wetcat\Board;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Aliasloader;

/*
 * iziBoard
 * Copyright (C) 2014  Andreas Göransson
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

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
		$this->app->register('Intervention\Image\ImageServiceProvider');

		$this->app['izi.init'] = $this->app->share(function () {
			return new Commands\InitBoardCommand();
		});

		$this->commands('izi.init');
	}

	public function boot()
	{
		$this->package('wetcat/board');

    include __DIR__.'/../../routes.php';
		//include __DIR__.'/../../filters.php';

    // AuthToken
		$this->app->register('Tappleby\AuthToken\AuthTokenServiceProvider');

    $this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  // Intervention
		  $loader->alias('Image', 'Intervention\Image\Facades\Image');
		  // AuthToken
		  $loader->alias('AuthToken', 'Tappleby\Support\Facades\AuthToken');
		  $loader->alias('AuthTokenNotAuthorizedException', 'Tappleby\AuthToken\Exceptions\NotAuthorizedException');
		});

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
