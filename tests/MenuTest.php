<?php

use EGALL\Menus\Menu;
use EGALL\Menus\MenuItem;

class MenuTest extends PHPUnit_Framework_TestCase {

  protected $menu;

  public function setUp() {

    $this->menu = new Menu();

  }

  /** @test */
  public function it_creates_a_new_menu_instance() {

    $this->assertInstanceOf(Menu::class, $this->menu);

  }

  /** @test */
  public function it_returns_a_menu_item_instance() {

    $item = $this->menu->add('Item', ['url' => '#']);

    $this->assertInstanceOf(MenuItem::class, $item);

  }

  /** @test */
  public function it_returns_an_array_of_root_level_menu_items() {

    $item = $this->menu->add('Item', ['url' => '#']);

    $roots = $this->menu->roots();

    $this->assertEquals([$item], $roots);

  }
  
  /** @test */
  public function it_returns_the_child_elements_by_id() {

    $item = $this->menu->add('Item', ['url' => '#']);

    $child = $item->add('Child Item', ['url' => 'child_item.php']);

    $this->assertEquals([1 => $child], $this->menu->whereParent(1));

  }

  /** @test */
  public function it_renders_the_menus_list_items() {

    $item = $this->menu->add('Item', ['url' => 'admin']);
    $br = "\n";
    $tab = "\t";
    //$this->assertEquals("<li>\n\t<a href=\"admin\">Item</a>\n</li>", $this->menu->render());
    $this->assertEquals("{$br}<li>{$br}{$tab}<a href=\"admin\">Item</a>{$br}</li>", $this->menu->render());

  }

  /** @test */
  public function it_renders_a_menu_items_children() {

    $item = $this->menu->add('Item', ['url' => 'admin']);

    $item->add('Child', ['url' => 'child.php']);

    $br = "\n";
    $tab = "\t";

    $expected = "{$br}<li>{$br}{$tab}";
    $expected .= "<a href=\"admin\">Item</a>{$br}{$tab}";
    $expected .= "<ul class=\"treeview-menu\">{$br}";
    $expected .= "<li>{$br}{$tab}";
    $expected .= "<a href=\"child.php\">Child</a>{$br}";
    $expected .= "</li>{$br}";
    $expected .= "</ul>{$br}";
    $expected .= "</li>";

    $this->assertEquals($expected, $this->menu->render());
  }

  /** @test */
  public function it_returns_the_url_key_from_an_array() {

    $url = $this->menu->getURL(['url' => 'index.php', 'class' => 'navbar-link']);

    $this->assertEquals('index.php', $url);

  }

  /** @test */
  public function it_returns_an_array_of_attributes_except_reserved_words() {

    $array = ['url' => 'index.php', 'class' => 'navbar'];

    $extracted = $this->menu->extractAttributes($array);

    $this->assertArrayNotHasKey('url', $extracted);

    $this->assertEquals(['class' => 'navbar'], $extracted);
  }

  /** @test */
  public function it_parses_attributes_into_an_html_format() {

    $attributes = ['class' => 'navbar'];

    $string = ' class="navbar"';

    $this->assertEquals($string, $this->menu->parseAttributes($attributes));
  }

  /** @test */
  public function it_counts_the_items_in_the_menu() {

    $this->menu->add('item1', ['url' => 'item1.php']);
    $this->menu->add('item2', ['url' => 'item2.php']);

    $this->assertEquals(2, $this->menu->length());

    $this->menu->add('item2', ['url' => 'item2.php']);
    $this->assertEquals(3, $this->menu->length());

  }
}
