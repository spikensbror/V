<?php

namespace V\Core;

class Module_Mock extends Module {}

class Module_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->module = new Module_Mock(false);
		$this->vModule = new Module_Mock(true);
	}

	public function testVolatile()
	{
		$this->assertFalse($this->module->isVolatile());
		$this->assertTrue($this->vModule->isVolatile());
	}
}