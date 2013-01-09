<?php

namespace V\Core;

class BaseClass_Mock extends BaseClass {}

class BaseClass_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->class = new BaseClass_Mock(false);
		$this->vClass = new BaseClass_Mock(true);
	}

	public function testVolatile()
	{
		$this->assertFalse($this->class->isVolatile());
		$this->assertTrue($this->vClass->isVolatile());

		$this->class->setVolatile(true);
		$this->vClass->setVolatile(false);
		$this->assertFalse($this->vClass->isVolatile());
		$this->assertTrue($this->class->isVolatile());
	}
}