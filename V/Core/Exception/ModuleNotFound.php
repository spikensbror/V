<?php

namespace V\Core\Exception;

class ModuleNotFound extends Base
{
	function __construct($class, $method, $module)
	{
		parent::__construct(
			$class,
			$method,
			"Module not found - '$module'"
		);
	}
}