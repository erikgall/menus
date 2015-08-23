<?php

use EGALL\Menus\Menu;
use EGALL\Menus\MenuItem;

class MenuItemTest extends \PHPUnit_Framework_TestCase {

  protected $menu;

  protected $menuItem;

  public function setUp() {

    $this->menu = new Menu();

    $this->menuItem = new MenuItem($this->menu, 'Item Title', 'index.php', ['class' => 'navbar-item']);

  }

  /** @test */
  public function it_creates_a_link_instance_for_the_menu_item() {

    $this->assertInstanceOf(\EGALL\Menus\Link::class, $this->menuItem->link);

  }

  /** @test */
  public function it_adds_a_child_to_the_menu_manager_instance_and_returns_the_child() {

    $child = $this->menuItem->add('Child', ['url' => 'child.php']);

    $this->assertInstanceOf(MenuItem::class, $child);

  }

  /** @test */
  public function it_gets_the_id_of_the_menu_item() {

    $item = $this->menu->add('Item 2', ['url' => 'index.php', 'class' => 'navbar-item']);

    $id = $item->getID();

    $this->assertEquals(1, $id);

  }

  /** @test */
  public function it_gets_the_items_parent_id() {

    $item = $this->menu->add('parent', ['url' => 'parent']);

    $child = $item->add('child', ['url' => 'child']);

    $this->assertEquals(0, $item->getPID());

    $this->assertEquals(1, $child->getPID());
  }

  /** @test */
  public function it_returns_true_if_an_item_has_children() {

    $item = $this->menu->add('parent', ['url' => 'parent']);

    $child = $item->add('child', ['url' => 'child']);

    $this->assertTrue($item->hasChildren());

    $this->assertFalse($child->hasChildren());

  }

  /** @test */
  public function it_returns_the_items_children() {

    $item = $this->menu->add('parent', ['url' => 'parent']);

    $child = $item->add('child', ['url' => 'child']);

    $this->assertEquals([1 => $child], $item->children());

    $child2 = $item->add('child2', ['url' => 'child']);

    $this->assertEquals([1 => $child, 2 => $child2], $item->children());
  }

}
