<?php

namespace V\HTTP;

class Module extends \V\Core\Module
{
	private $_router = null;
	private $_status = null;

	public function route()
	{
		return ($this->_router)
			? $this->_router
			: ($this->_router = new Router());
	}

	public function status()
	{
		return ($this->_status)
			? $this->_status
			: ($this->_status = new Status());
	}
}