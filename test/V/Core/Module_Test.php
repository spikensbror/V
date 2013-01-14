<?php

namespace V\Core;

class Module_Mock extends Module {}

class Module_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->module = new Module_Mock(false);
	}

	public function testPlaceholder()
	{
		$this->assertTrue(true);
	}
}