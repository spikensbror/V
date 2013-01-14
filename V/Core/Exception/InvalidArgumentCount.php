<?php

namespace V\Core\Exception;

class InvalidArgumentCount extends Base
{
	function __construct($class, $method, $expected, $got)
	{
		parent::__construct(
			$class,
			$method,
			"Invalid argument count, expected '$expected', got '$got'."
		);
	}
}