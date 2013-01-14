<?php

namespace V\URL;

class Router_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->router = new Router();
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
		$this->assertEquals(
			'POST',
			$this->router->sanitizeVerb('post')
		);
		$this->assertEquals(
			'GET',
			$this->router->sanitizeVerb('invalid')
		);
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
	public function testResolveRouteNotFoundException()
	{
		$this->setExpectedException('\V\URL\Exception\RouteNotFound');
		$this->router->resolve('GET', '/does/not/exist/');
	}

	/**
	 * @depends testAddAndResolve
	 */
	public function testAddRouteNotCallableException()
	{
		$this->setExpectedException('\V\URL\Exception\RouteNotCallable');
		$this->router->add('GET', '/', array());
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
	public function testMagicInvalidArgumentCountException()
	{
		$this->setExpectedException('\V\Core\Exception\InvalidArgumentCount');
		$this->router->post('/');
	}
}