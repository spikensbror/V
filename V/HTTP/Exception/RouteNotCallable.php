<?php

namespace V\HTTP\Exception;

class RouteNotCallable extends \V\Core\Exception\Base
{
	function __construct($class, $method, $verb, $path)
	{
		parent::__construct(
			$class,
			$method,
			"Route not callable - '$verb':'$path'"
		);
	}
}