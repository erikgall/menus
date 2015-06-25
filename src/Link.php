<?php

namespace EGALL\Menus\Src;

/**
 * Menu Item Link Class
 *
 * @package EGALL\Menus\Src
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.0.0
 */
class Link {

	/**
	 * The text to be displayed.
	 *
	 * @var
	 */
	public $text;

	/**
	 * This links's HTML attributes.
	 *
	 * @var array
	 */
	public $attributes;

	/**
	 * The url for the current link.
	 *
	 * @var
	 */
	public $url;

	/**
	 * The child containers class such as the unordered
	 * list that this item is a parent to's class.
	 *
	 * @var string
	 */
	public $childContainerClass = 'treeview-menu';

	/**
	 * Link class constructor.
	 *
	 * @param $text
	 * @param $url
	 * @param array $attributes
	 */
	public function __construct($text, $url, array $attributes = []) {

		$this->text = $text;

		$this->url = $url;

		$this->attributes = $attributes;
		
	}

	/**
	 * Get the items url.
	 *
	 * @return mixed
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * Get this items text.
	 *
	 * @return mixed
	 */
	public function get_text() {
		return $this->text;
	}

	/**
	 * Append content to this items text.
	 *
	 * @param $content
	 * @return $this
	 */
	public function append($content) {

		$this->text .= $content;

		return $this;

	}

	/**
	 * Prepend content to this items text.
	 *
	 * @param $content
	 * @return $this
	 */
	public function prepend($content) {

		$this->text = $content . $this->text;

		return $this;
		
	}

	/**
	 * Wrap this items text in an html tag such as a span.
	 *
	 * @param string $opening
	 * @param string|null $closing
	 * @return $this Return this for method chaining.
	 */
	public function wrap($opening, $closing = NULL) {

		$this->text = "<{$opening}>" . $this->text;

		$this->text .= $closing === NULL ? "</{$opening}>" : "</{$closing}>";

		return $this;

	}

	/**
	 * Append a font awesome icon to the text.
	 *
	 * @param $icon
	 * @return $this
	 */
	public function icon($icon) {
		$this->text = "<i class=\"fa fa-{$icon}\"></i> " . $this->text;

		return $this;
	}

	/**
	 * Append a glyphicon to the text.
	 *
	 * @param $icon
	 * @return $this
	 */
	public function glyph($icon) {

		$this->text = "<i class=\"glyphicon glyphicon-{$icon}\"></i> " . $this->text;

		return $this;
	}

	/**
	 * Append a left angle icon to the text.
	 *
	 * @return $this
	 */
	public function angleLeft() {

		$this->append("<i class=\"fa fa-angle-left pull-right\"></i>");

		return $this;
	}

	/**
	 * This items HTML attributes.
	 *
	 * @param null $key
	 * @param null $val
	 * @return $this|array|null
	 */
	public function attributes($key = NULL, $val = NULL) {

		$args = func_get_args();

		if (is_array($args[0])) {

			$this->attributes = array_merge($this->attributes, $args[0]);

			return $this;

		}
		else if (isset($args[0])) {

			if (isset($args[1])) {

				$this->attributes[$args[0]] = $args[1];

				return $this;

			}
			else {

				return isset($this->attributes[$args[0]]) ? $this->attributes[$args[0]] : NULL;

			}

			return $this->attributes;

		}
 	}
}