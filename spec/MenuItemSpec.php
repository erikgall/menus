<?php

namespace spec\EGALL\Menus\Src;

use EGALL\Menus\Src\Menu;
use EGALL\Menus\Src\MenuItem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MenuItemSpec extends ObjectBehavior
{

	protected $menu;
	function let() {
		$this->menu = new Menu();
		$this->beConstructedWith($this->menu, 'Menu Item', 'Item-url');
	}

  function it_is_initializable() {
      $this->shouldHaveType('EGALL\Menus\Src\MenuItem');
  }

	function it_should_add_the_item_to_the_menu_and_return_the_menu_item_instance() {
		$this->add('Item_title', ['url' => 'item-url'])->shouldHaveType('EGALL\Menus\Src\MenuItem');
	}

	function it_will_return_the_current_menu_items_id() {

		$this->getId()->shouldEqual(1);

	}

	function it_will_get_the_current_items_id() {

		$this->getId()->shouldEqual(1);

	}

	function it_will_add_a_child_menu_item() {

		$this->add('Item_title', ['url' => 'item-url']);

		$this->hasChildren()->shouldReturn(TRUE);

		$this->children()->shouldBeArray();

		$this->children()[0]->shouldHaveType('EGALL\Menus\Src\MenuItem');

		var_dump($this->children()[0]->getId()->getWrappedObject());
		var_dump($this->children()[0]->getPid()->getWrappedObject());
	}

	function it_will_contain_an_instance_of_the_link_class() {
		$this->link->shouldHaveType('EGALL\Menus\Src\Link');
	}
}
