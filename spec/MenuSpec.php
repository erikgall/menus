<?php

namespace spec\EGALL\Menus\Src;

use EGALL\Menus\Src\Menu;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MenuSpec extends ObjectBehavior {

	function it_is_initializable() {
		$this->shouldHaveType('EGALL\Menus\Src\Menu');
	}

	function it_will_return_an_instance_of_menu_item() {

		$item = $this->add('Home', ['url' => '/home', 'class' => 'btn']);

		$second = $this->add('About', ['url' => 'about']);

		$item->shouldBeAnInstanceOf('EGALL\Menus\Src\MenuItem');

		$second->shouldBeAnInstanceOf('EGALL\Menus\Src\MenuItem');

	}

	function it_will_render_a_formatted_list_item() {


		$about = $this->add('About', ['url' => 'about']);

		$about->link->append(' <span class="caret"></span>');

		$about->link->attributes(['class' => 'link-item', 'target' => '_blank']);

		$expected = "\n<li>";
		$expected .= "\n\t<a href=\"about\" class=\"link-item\" target=\"_blank\">About <span class=\"caret\"></span></a>";
		$expected .= "\n</li>";

		$this->render()->shouldReturn($expected);

	}

	function it_will_return_a_url_from_an_array() {

		$options = [
			'class' => 'btn btn-edit',
			'url' => 'http://testing.com'
		];

		$expected = 'http://testing.com';
		$this->getUrl($options)->shouldReturn('http://testing.com');

	}

	function it_will_return_a_url() {

		$this->getUrl('http://testing.com')->shouldReturn('http://testing.com');

	}

	function it_will_return_null_if_no_url_is_supplied() {
		$this->getUrl()->shouldBeNull();
	}

	function it_will_parse_an_array_to_a_formatted_html_attributes_string() {

		$attributes = [
			'class' => 'btn btn-edit',
			'id' => 'test-btn',
			'data-toggle' => 'dropdown'
		];

		$expected = " class=\"btn btn-edit\" id=\"test-btn\" data-toggle=\"dropdown\"";
		$this->parseAttributes($attributes)->shouldReturn($expected);

	}

	function it_will_return_the_number_of_items_in_the_menu() {

		$this->add('Home', 'home');
		$this->add('About', 'about');

		// Should return (2) menu items
		$this->length()->shouldBeEqualTo(2);

		$this->add('Contact', 'contact');

		// Should return (3) menu items
		$this->length()->shouldBeEqualTo(3);


	}

	function it_will_extract_html_attributes_except_url_and_parent_id() {

		$attributes = [
			'url' => 'home',
			'pid' => 1,
			'class' => 'btn'
		];

		$this->extractAttributes($attributes)->getWrappedObject();

	}
}
