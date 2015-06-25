<?php

namespace EGALL\Menus\Src;

/**
 * Menu Item Class
 *
 * @package EGALL\Menus\Src
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.0.0
 */
class MenuItem {

	/**
	 * The menu class instance.
	 *
	 * @var Menu
	 */
	protected $manager;

	/**
	 * The menu items title or text that is displayed.
	 *
	 * @var
	 */
	protected $title;

	/**
	 * This menu items id in the array
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * This menu items parent id or level
	 *
	 * @var int
	 */
	protected $pid;

	/**
	 * The items meta data passed in.
	 *
	 * @var
	 */
	protected $meta;

	/**
	 * The items html attributes that will be displayed.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The link class' instance.
	 *
	 * @var Link
	 */
	public $link;

	/**
	 * Menu item constructor.
	 *
	 * @param Menu $manger
	 * @param $title
	 * @param $url
	 * @param array $attributes
	 * @param int $pid
	 */
	public function __construct(Menu $manger, $title, $url, array $attributes = [], $pid = 0) {

		$this->manager = $manger;
		$this->id = $this->id();
		$this->pid = $pid;
		$this->title = $title;
		$this->attributes = $attributes;

		$this->link = new Link($title, $url);

	}

	/**
	 * Add a child menu item and add it to the main menu instance.
	 *
	 * @param $title
	 * @param array $options
	 * @return MenuItem
	 */
	public function add($title, array $options = []) {

		if (!is_array($options)) {
			$options = ['url' => $options];
		}

		$options['pid'] = $this->id;

		return $this->manager->add($title, $options);
	}

	/**
	 * Get an ID for this menu item.
	 *
	 * @return int
	 */
	protected function id() {
		return $this->manager->length() + 1;
	}

	/**
	 * Get this item's unique ID.
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get this menu items pid.
	 *
	 * @return int
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Check and see if the current menu item has any children.
	 *
	 * @return bool
	 */
	public function hasChildren() {
		return count($this->manager->whereParent($this->id)) ? TRUE : FALSE;
	}

	/**
	 * Get this items children from the menu manager.
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
	 * Get this items meta data.
	 *
	 * @param $key
	 * @param $val
	 * @return $this|null
	 */
	public function meta($key, $val) {

		$args = func_get_args();

		if (is_array($args[0])) {

			$this->meta = array_merge($this->meta, $args[0]);

			return $this;

		}
		else if (isset($args[0])) {

			if (isset($args[1])) {

				$this->meta[$args[0]] = $args[1];

				return $this;

			}
			else {

				return isset($this->meta[$args[0]]) ? $this->meta[$args[0]] : NULL;

			}

		}

		return $this->meta;
	}
}
