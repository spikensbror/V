<?php

namespace V\Core;

abstract class BaseClass
{
	private $_volatile = false;

	function __construct($volatile = false)
	{
		$this->_volatile = $volatile;
	}

	public function isVolatile()
	{
		return $this->_volatile;
	}

	public function setVolatile($volatile)
	{
		return ($this->_volatile = $volatile);
	}
}