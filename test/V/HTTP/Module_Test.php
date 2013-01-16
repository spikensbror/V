<?php

namespace V\HTTP;

class Module_Test extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->module = new Module(false);
	}

	public function testProviders()
	{
		$this->assertInstanceOf('V\\HTTP\\Router', $this->module->route());
		$this->assertInstanceOf('V\\HTTP\\Status', $this->module->status());
	}
}