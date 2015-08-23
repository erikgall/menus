<?php

use EGALL\Menus\Link;

class LinkTest extends PHPUnit_Framework_TestCase {

  protected $link;

  public function setUp() {

    $this->link = new Link('Link', 'index.php', ['class' => 'menu-link']);

  }

  /** @test */
  public function it_returns_the_links_url() {
    $this->assertEquals('index.php', $this->link->getURL());
  }

  /** @test */
  public function it_returns_the_links_text() {

    $this->assertEquals('Link', $this->link->getText());
  }

  /** @test */
  public function it_appends_text_to_the_links_text() {

    $this->link->append(' Append');

    $this->assertEquals('Link Append', $this->link->getText());
  }

  /** @test */
  public function it_prepends_text_to_the_links_text() {

    $this->link->prepend('Prepend ');

    $this->assertEquals('Prepend Link', $this->link->getText());
  }


  /** @test */
  public function it_wraps_the_text_in_an_html_attributes() {

    $this->link->wrap('div');

    $this->assertEquals('<div>Link</div>', $this->link->getText());
  }

  /** @test */
  public function it_prepends_a_font_awesome_icon_to_the_text() {

    $this->link->fa('dashboard');

    $this->assertEquals('<i class="fa fa-dashboard"></i> Link', $this->link->getText());
  }

  /** @test */
  public function it_prepends_a_glyphicon_to_the_text() {

    $this->link->glyph('dashboard');

    $this->assertEquals('<i class="glyphicon glyphicon-dashboard"></i> Link', $this->link->getText());
  }

}
