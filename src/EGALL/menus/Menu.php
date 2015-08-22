<?php

namespace EGALL\Menus;

use Closure;

/**
 * Menu manager
 *
 * @package EGALL\Menus
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.1.0
 */
class Menu {

  /**
   * The array of menu items belonging to this menu.
   *
   * @var array
   */
  protected $menu = [];

  /**
   * Attributes not includes in the menu link.
   *
   * @var array
   */
  protected $reserved = ['pid', 'url'];

  /**
   * Build the menu and create a new instance of itself.
   *
   * @param $name
   * @param Closure $callback
   * @return Menu
   */
  public function build($name, Closure $callback) {

    if (is_callable($callback)) {

      $menu = new self;

      call_user_func($callback, $menu);

      return $menu;

    }

  }

  /**
   * Add a new menu item to the menu.
   *
   * @param $title
   * @param array $options
   * @return MenuItem
   */
  public function add($title, $options = []) {

    $url = $this->getURL($options);

    // Set the items parent ID
    $pid = isset($options['pid']) ? $options['pid'] : null;

    // Extract the attributes and create a new menu item instance
    $attributes = (is_array($options)) ? $this->extractAttributes($options) : [];

    $item = new MenuItem($this, $title, $url, $attributes, $pid);

    array_push($this->menu, $item);

    return $item;

  }

  /**
   * Get the root level menu items.
   *
   * @return array
   */
  public function roots() {

    return $this->whereParent();

  }

  /**
   * Get items at a specific level of the menu.
   *
   * @param null $parent
   * @return array
   */
  public function whereParent($parent = null) {

    return array_filter($this->menu, function ($item) use ($parent) {
      return ($item->getPid() === $parent) ? true : false;
    });

  }

  /**
   * Filter items by a user defined callback.
   *
   * @param Closure $closure
   * @return $this
   */
  public function filter(Closure $closure) {

    if (is_callable($closure)) {
      $this->menu = array_filter($this->menu, $closure);
    }

    return $this;

  }

  /**
   * Get the menu's HTML.
   *
   * @param string $type
   * @param null $pid
   * @return string
   */
  public function render($type = 'ul', $pid = NULL) {

    $items = '';

    $element = in_array($type, ['ul', 'ol']) ? 'li' : $type;

    foreach ($this->whereParent($pid) as $item) {

      $items .= "\n<{$element}{$this->parseAttributes($item->attributes())}>";

      if (!is_null($item->link->url)) {
        $items .= "\n\t<a href=\"{$item->link->url}\"{$this->parseAttributes($item->link->attributes)}>";
        $items .= $item->link->text;
        $items .= "</a>";
      }
      else {
        $items .= $item->link->text;
      }

      if ($item->hasChildren()) {

        $items .= "\n\t<{$type}";
        $items .= $type == 'ul' ? " class=\"{$item->link->childContainerClass}\">" : ">";
        $items .= "\t\t" . $this->render($type, $item->getId());
        $items .= "</{$type}>";

      }

      $items .= "\n</{$element}>";

    }
    
    return $items;
    
  }

  /**
   * Get the menu items URL from it's attributes.
   *
   * @param array $options
   * @return array|null
   */
  public function getURL($options = []) {

    if (!is_array($options)) {
      return $options;
    }

    if (isset($options['url'])) {
      return $options['url'];
    }

    return null;
    
  }

  /**
   * Extract the menu items attributes and reserved keys from the options.
   *
   * @param array $options
   * @return array
   */
  public function extractAttributes(array $options = []) {
    return array_diff_key($options, array_flip($this->reserved));
  }

  /**
   * Count the number of menu items added.
   *
   * @return int
   */
  public function length() {
    return count($this->menu);
  }

  /**
   * Render the menu as an unordered list.
   *
   * @param array $attributes
   * @return string
   */
  public function asUl(array $attributes = []) {
    return "<ul{$this->parseAttributes($attributes)}>{$this->render('ul')}</ul>";
  }

  /**
   * Render the menu as an ordered list.
   *
   * @param array $attributes
   * @return string
   */
  public function asOl(array $attributes = []) {
    return "<ol{$this->parseAttributes($attributes)}>{$this->render('ol')}</ol>";
  }

  /**
   * Render the menu with a div wrapper.
   *
   * @param array $attributes
   * @return string
   */
  public function asDiv(array $attributes = []) {
    return "<div{$this->parseAttributes($attributes)}>{$this->render('div')}</div>";
  }

}