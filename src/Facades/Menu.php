<?php

namespace EGALL\Menus\Src\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Menu Facade
 *
 * @package EGALL\Menus\Src\Facades
 */
class Menu extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'menu';
  }


}