<?php

namespace EGALL\Menus\Src;

use Closure;

/**
 * Menu Class
 *
 * @package EGALL\Menus\Src
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.0.0
 */
class Menu {

	/**
	 * The array of all menu items.
	 *
	 * @var array
	 */
	protected $menu = [];

	/**
	 * Attributes not included in the html.
	 *
	 * @var array
	 */
	protected $reserved = ['pid', 'url'];

	/**
	 * Build function used with a closure to generate the menu.
	 *
	 * @param $name The name of the menu.
	 * @param Closure $callback The callback function used.
	 * @return Menu
	 */
	public function build($name, Closure $callback)
	{
		if(is_callable($callback))
		{
			$menu = new Self;

			// Registering the items
			call_user_func($callback, $menu);

			return $menu;
		}
	}

	/**
	 * Create a new menu item and add it to the menu array.
	 *
	 * @param $title The text to be displayed
	 * @param array $options The html attributes for that item
	 * @return MenuItem
	 */
	public function add($title, $options = []) {

		// Get the url
		$url = $this->getURL($options);

		// Set the items parent ID
		$pid = isset($options['pid']) ? $options['pid'] : NULL;

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
	 * Get items at a specific level.
	 *
	 * @param null $parent
	 * @return array
	 */
	public function whereParent($parent = NULL) {

		return array_filter($this->menu, function($item) use ($parent) {

			return ($item->getPid() === $parent) ? TRUE : FALSE;

		});

	}

	/**
	 * Filter items by a user callback function.
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
	 * Render the menu items and their HTML.
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

			$items .= $item->link->url !== NULL ? "\n\t<a href=\"{$item->link->url}\"{$this->parseAttributes($item->link->attributes)}>{$item->link->text}</a>" : "{$item->link->text}";

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
	 * Get the items url from an array, or as a string.
	 *
	 * @param array|string $options
	 * @return array|string|null
	 */
	public function getURL($options = []) {

		if (!is_array(($options))) {
			return $options;
		}

		if (isset($options['url'])) {
			return $options['url'];
		}

		return NULL;


	}

	/**
	 * Extract an items attributes and take the url and pid items
	 * out of the attributes array.
	 *
	 * @param array $options
	 * @return array
	 */
	public function extractAttributes(array $options = []) {
		return array_diff_key($options, array_flip($this->reserved));
	}

	/**
	 * Parse an elements attributes into HTML.
	 *
	 * @param array $attributes
	 * @return string
	 */
	public function parseAttributes(array $attributes = []) {

		$html = [];

		foreach($attributes as $key => $val) {

			if (is_numeric($key)) {
				$key = $val;
			}

			$element = (!is_null($val)) ? "{$key}=\"{$val}\"" : NULL;

			$element === NULL OR $html[] = $element;

		}

		return count($html) > 0 ? ' '.implode(' ', $html) : '';
	}

	/**
	 * Get the total number of menu items.
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
	 * Render the menu with div tags.
	 *
	 * @param array $attributes
	 * @return string
	 */
	public function asDiv(array $attributes = []) {
		return "<div{$this->parseAttributes($attributes)}>{$this->render('div')}</div>";
	}
}