<?php

namespace V\HTTP\Exception;

class RouteNotFound extends \V\Core\Exception\Base
{
	function __construct($class, $method, $verb, $path)
	{
		parent::__construct(
			$class,
			$method,
			"Route not found - '$verb':'$path'"
		);
	}
}