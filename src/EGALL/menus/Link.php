<?php

namespace EGALL\Menus;

/**
 * A menu item's anchor class.
 *
 * @package EGALL\Menus
 * @author Erik Galloway <erik@mybarnapp.com>
 * @version 1.1.0
 */
class Link {

  /**
   * The text to be displayed.
   *
   * @var
   */
  protected $text;

  /**
   * The anchors attributes.
   *
   * @var array
   */
  protected $attributes = [];

  /**
   * The url for the anchor.
   *
   * @var
   */
  protected $url;

  /**
   * The containter class for a child menu item.
   *
   * @var string
   */
  public $childContainerClass;

  /**
   * @param string $text
   * @param string $url
   * @param array $attributes
   * @param null $childContainerClass
   */
  public function __construct($text, $url, array $attributes = [], $childContainerClass = '') {

    $this->text = $text;

    $this->url = $url;

    $this->attributes = $attributes;

    $this->childContainerClass = $childContainerClass;

  }

  /**
   * Get the items URL.
   *
   * @return mixed
   */
  public function getURL() {
    return $this->url;
  }

  /**
   * Get the items text to be displayed.
   *
   * @return mixed
   */
  public function getText() {
    return $this->text;
  }

  /**
   * Append text to the items text.
   *
   * @param $text
   * @return $this
   */
  public function append($text) {

    $this->text .= $text;

    return $this;

  }

  /**
   * Prepend text to the item.
   *
   * @param $text
   * @return $this
   */
  public function prepend($text) {

    $this->text = $text . $this->text;

    return $this;

  }

  /**
   * Wrap the item in an html element.
   *
   * @param $opening
   * @param null $closing
   * @return $this
   */
  public function wrap($opening, $closing = null) {

    $this->text = "<{$opening}>{$this->text}";

    $this->text .= is_null($closing) ? "</{$opening}>" : "</{$closing}>";

    return $this;

  }

  /**
   * Prepend a font awesome icon.
   *
   * @param $icon
   * @return Link
   */
  public function fa($icon) {
    return $this->prepend($this->icon($icon));
  }

  /**
   * Prepend a glyphicon to the text.
   *
   * @param $icon
   * @return Link
   */
  public function glyph($icon) {
    return $this->prepend($this->icon($icon, false));
  }

  /**
   * Append a angle left font awesome icon to the text.
   *
   * @return Link
   */
  public function iconLeft() {

    return $this->fa('angle-left pull-right');

  }

  /**
   * The items attributes that were passed in.
   *
   * @param null $key
   * @param null $val
   * @return array|Link
   */
  public function attributes($key = null, $val = null) {

    $args = func_get_args();

    if (isset($args[0]) && isset($args[1])) {

      return $this->setAttributesKeyValuePair($args[0], $args[1]);


    }
    elseif (isset($args[0])) {

      if (is_array($args[0])) {
        return $this->setAttributesArrayData($args[0]);
      }
      else {
       return $this->attributes[$args[0]];
      }
    }

    return $this->attributes;
  }

  /**
   * Get the icons HTML for this link.
   *
   * @param $icon
   * @param bool|true $font_awesome
   * @return string
   */
  private function icon($icon, $font_awesome = true) {

    $html = "<i class=\"";

    if ($font_awesome == true) {
      $html .= "fa fa-{$icon}\">";
    }
    else {
      $html .= "glphicon glpyphicon-{$icon}\">";
    }

    $html .= "</i>";

    return $html;
  }

  /**
   * Set the attributes data if the argument passed in is an array.
   *
   * @param array $data
   * @return $this
   */
  private function setAttributesArrayData(array $data = []) {

    $this->attributes = array_merge($this->attributes, $data);

    return $this;

  }

  /**
   * Set the attributes data if the arguments are a key, value pair
   *
   * @param $key
   * @param $val
   * @return $this
   */
  private function setAttributesKeyValuePair($key, $val) {

    $this->attributes[$key] = $val;

    return $this;

  }
}