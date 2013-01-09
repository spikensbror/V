<?php

namespace V\URL;

class Module extends \V\Core\Module
{
	private $_router = null;

	public function route()
	{
		return ($this->_router)
			? $this->_router
			: ($this->_router = new Router($this->isVolatile()));
	}
}