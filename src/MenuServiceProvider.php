<?php

namespace EGALL\Menus\Src;

use Illuminate\Support\ServiceProvider;

/**
 * Menu Service Provider for Laravel 5.1
 *
 * @package EGALL\Menus\Src
 */
class MenuServiceProvider extends ServiceProvider {

	/**
	 * Defer the loading of this provider.
	 *
	 * @var bool
	 */
	protected $defer = TRUE;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerMenu();
	}

	/**
	 * @return array
	 */
	public function provides() {
		return ['menu'];
	}

	/**
	 * Bind the menu to the app and return a menu class instance.
	 */
	protected function registerMenu() {

		$this->app->bind('menu', function($app) {
			return new Menu();
		});

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {}
}
