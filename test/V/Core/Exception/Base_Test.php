<?php

namespace V\Core\Exception;

class Exception_Mock extends Base {}

class Base_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->e = new Exception_Mock(
			'Test',
			'someMethod',
			'Some exception occured!'
		);
	}

	public function testGetters()
	{
		$this->assertEquals('Test', $this->e->getClass());
		$this->assertEquals('someMethod', $this->e->getMethod());
		$this->assertEquals('Some exception occured!', $this->e->getMessage());
		$this->assertEquals(date('Ymd'), $this->e->getTime('Ymd'));
	}

	public function testToString()
	{
		$this->assertEquals(
			'[Test - someMethod()]: Some exception occured!',
			$this->e->toString()
		);

		$this->assertEquals(
			'('.
				date('Ymd').
			') - [Test - someMethod()]: Some exception occured!',
			$this->e->toString('Ymd')
		);
	}
}