<?php

namespace V\URL;

class Router_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->router = new Router(false);
		$this->vRouter = new Router(true);
	}

	public function testSanitizePath()
	{
		$this->assertEquals(
			'/',
			$this->router->sanitizePath('')
		);
		$this->assertEquals(
			'test/hello',
			$this->router->sanitizePath('/test/hello//')
		);
		$this->assertEquals(
			'test/world/hello',
			$this->router->sanitizePath('/test////world///////hello//')
		);
	}

	public function testAddAndGet()
	{
		$this->router->add('GET', '/', function() {
			return 1449;
		});
		$this->router->add('POST', '/', function() {
			return 1775;
		});
		$this->router->add('DELETE', '/', function() {
			return 4882;
		});

		$this->assertEquals(
			1449,
			call_user_func($this->router->get('GET', '/'))
		);
		$this->assertEquals(
			1775,
			call_user_func($this->router->get('POST', '/'))
		);
		$this->assertEquals(
			4882,
			call_user_func($this->router->get('DELETE', '/'))
		);
	}

	public function testAddVolatile()
	{
		$this->vRouter->add('GET', '/', function() {});

		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->add('GET', '/', function() {});
	}

	public function testGetVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->get('GET', '/');
	}
}