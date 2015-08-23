<?php

namespace EGALL\Menus;

use Illuminate\Support\ServiceProvider;

/**
 * Menu service provider for Laravel 5.1.10.
 *
 * @package EGALL\Menus
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.1.0
 */
class MenuServiceProvider extends ServiceProvider {

  /**
   * Defer the loading of this package.
   *
   * @var bool
   */
  protected $defer = true;

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot() {
    $this->app->bind('EGALL\Menus\Menu', function ($app) {
      return new Menu();
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return ['menu'];
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register() {
    //
  }
}
