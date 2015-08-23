<?php

namespace EGALL\Menus;

/**
 * Individual menu item class.
 *
 * @package EGALL\Menus
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.1.0
 */
class MenuItem {

  /**
   * The parent menu class instance.
   *
   * @var object
   */
  protected $manager;

  /**
   * The title/text to display for this item.
   *
   * @var string
   */
  protected $title;

  /**
   * This menu items id.
   *
   * @var int
   */
  protected $id;

  /**
   * This menu items parent or level.
   *
   * @var int
   */
  protected $pid;

  /**
   * The items meta attributes passed in.
   *
   * @var array
   */
  protected $meta;

  /**
   * HTML attributes passed in to be rendered.
   *
   * @var array
   */
  protected $attributes = [];

  /**
   * This menu items link instance.
   *
   * @var object
   */
  public $link;

  /**
   * Menu item constructor.
   *
   * @param Menu $manager
   * @param string $title
   * @param string $url
   * @param array $attributes
   * @param int $pid
   */
  public function __construct(Menu $manager, $title, $url, array $attributes = [], $pid = 0) {

    $this->manager = $manager;
    $this->title = $title;
    $this->attributes = $attributes;

    $this->pid = $pid;
    $this->setID($manager);
    $this->setLink($url);

  }

  /**
   * Set the menu item's link
   *
   * @return void
   */
  private function setLink($url) {
    $this->link = new Link($this->title, $url);
  }

  /**
   * Add a child menu item to this item.
   *
   * @param $title
   * @param array $options
   * @return MenuItem
   */
  public function add($title, $options = []) {

    if (!is_array($options)) {
      $options = ['url' => $options];
    }

    $options['pid'] = $this->id;

    return $this->manager->add($title, $options);
    
  }

  /**
   * Set this menu items ID.
   *
   * @param Menu $menu
   * @return void
   */
  protected function setID(Menu $menu) {
    $this->id = $menu->length() + 1;
  }

  /**
   * Get this menu items
   *
   * @return int
   */
  public function getID() {
    return $this->id;
  }

  /**
   * Get this menu items parent ID.
   *
   * @return int
   */
  public function getPID() {
    return $this->pid;
  }

  /**
   * Check if this menu item has children.
   *
   * @return bool
   */
  public function hasChildren() {

    if  (count($this->manager->whereParent($this->id))) {
      return true;
    }

    return false;
  }

  /**
   * Get this items children.
   *
   * @return array
   */
  public function children() {
    return $this->manager->whereParent($this->id);
  }

  /**
   * Get this items attributes.
   *
   * @return $this|array|null
   */
  public function attributes() {

    $args = func_get_args();

    if(isset($args[0]) AND is_array($args[0])) {

      $this->attributes = array_merge($this->attributes, $args[0]);

      return $this;

    }
    elseif(isset($args[0]) && isset($args[1])) {

      $this->attributes[$args[0]] = $args[1];

      return $this;

    }
    elseif(isset($args[0])) {

      return isset($this->attributes[$args[0]]) ? $this->attributes[$args[0]] : null;
    }

    return $this->attributes;

  }

  /**
   * Get this items meta HTML attributes.
   *
   * @param $key
   * @param $val
   * @return array|MenuItem|null
   */
  public function meta($key, $val) {

    $args = func_get_args();

    if (is_array($args[0])) {

      return $this->setMetaArrayData($args[0]);

    }
    else if (isset($args[0])) {

      if (isset($args[1])) {

        return $this->setMetaKeyValueArray($args[0], $args[1]);

      }
      else {

        return isset($this->meta[$args[0]]) ? $this->meta[$args[0]] : null;

      }

    }

    return $this->meta;

  }

  /**
   * Set the meta data if the argument passed in is an array.
   *
   * @param array $data
   * @return $this
   */
  private function setMetaArrayData(array $data = []) {

    $this->meta = array_merge($this->meta, $data);

    return $this;

  }

  /**
   * Set the meta data if an array isn't passed in.
   *
   * @param $key
   * @param $val
   * @return $this
   */
  private function setMetaKeyValueArray($key, $val) {

    $this->meta[$key] = $val;

    return $this;

  }

}