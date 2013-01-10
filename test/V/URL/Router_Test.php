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

	/**
	 * @depends testSanitizePath
	 */
	public function testSanitizeVerb()
	{
		$this->assertEquals(
			'GET',
			$this->router->sanitizeVerb('get')
		);
	}

	/**
	 * @depends testSanitizeVerb
	 */
	public function testSanitizeVerbVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->sanitizeVerb('invalid');
	}

	/**
	 * @depends testSanitizePath
	 */
	public function testAddAndResolve()
	{
		$this->router->add('POST', '/', function() {
			return 1449;
		});

		$this->router->add('GET', '/:string/:int/', function($x, $y) {
			$y = $y * 10;
			return $x.' '.$y;
		});

		$this->assertEquals(
			1449,
			$this->router->resolve('POST', '/')
		);

		$this->assertEquals(
			'hello 120',
			$this->router->resolve('GET', '/hello/12/')
		);
	}

	/**
	 * @depends testAddAndResolve
	 */
	public function testAddVolatile()
	{
		$this->vRouter->add('GET', '/', function() {});

		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->add('GET', '/', function() {});
	}

	/**
	 * @depends testAddAndResolve
	 */
	public function testResolveVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->vRouter->raw('GET', '/');
	}

	/**
	 * @depends testAddAndResolve
	 */
	public function testMagic()
	{
		$this->router->post('/', function() {
			return 10;
		});

		$this->assertEquals(
			10,
			$this->router->resolve('POST', '/')
		);
	}

	/**
	 * @depends testMagic
	 */
	public function testMagicVolatile()
	{
		$this->setExpectedException('\V\Core\Exception');
		$this->router->post('/');
	}
}