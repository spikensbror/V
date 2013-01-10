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

	public function testSanitizeVerb()
	{
		$this->assertEquals(
			'GET',
			$this->router->sanitizeVerb('get')
		);
	}

	public function testSanitizeVerbVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->sanitizeVerb('invalid');
	}

	public function testAddAndRaw()
	{
		// Flat.
		$this->router->add('POST', '/', function() {
			return 1449;
		});

		// Flat.
		$flat = $this->router->raw('POST', '/');
		$this->assertTrue(is_callable($flat));
		$this->assertEquals(
			1449,
			call_user_func($flat)
		);

		// Multi.
		$this->router->add('GET', '/:string/:int/', function($x, $y) {
			$y = $y * 10;
			return $x.' '.$y;
		});

		// Multi.
		$multi = $this->router->raw('GET', '/hello/12/');
		$this->assertTrue(is_array($multi));
		$this->assertTrue(isset($multi['f']));
		$this->assertTrue(isset($multi['args']));
		$this->assertEquals(
			'hello 120',
			call_user_func_array($multi['f'], $multi['args'])
		);
	}

	public function testAddVolatile()
	{
		$this->vRouter->add('GET', '/', function() {});

		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->add('GET', '/', function() {});
	}

	public function testRawVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->raw('GET', '/');
	}

	/**
	 * @depends testAddAndRaw
	 */
	public function testMagic()
	{
		$this->router->post('/', function() {
			return 10;
		});

		$this->assertEquals(
			10,
			call_user_func($this->router->raw('POST', '/'))
		);
	}

	public function testMagicVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->router->post('/');
	}
}