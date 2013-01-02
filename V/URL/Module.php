<?php

namespace V\URL;

class Module extends \V\Core\Module
{
	private $_routers = null;

	public function route($parent = 'default')
	{
		$entry =& $this->_routers[$parent];
		if($entry) {
			return $entry;
		}

		return ($entry = new Router($parent));
	}
}