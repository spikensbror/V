<?php

namespace V\URL;

class Router extends \V\Core\BaseClass
{
	private $_routes = array();

	public function add($method, $path, $f)
	{
		$path = $this->sanitizePath($path);

		$entry =& $this->_routes[$method][$path];
		if($entry && $this->isVolatile()) {
			throw new \V\Core\Exception(
				__CLASS__,
				__METHOD__,
				"Route already exists - '$method':'$path'"
			);
		}

		return ($entry = $f);
	}

	public function get($method, $path)
	{
		$path = $this->sanitizePath($path);

		$entry =& $this->_routes[$method][$path];
		if(!$entry && $this->isVolatile()) {
			throw new \V\Core\Exception(
				__CLASS__,
				__METHOD__,
				"Route does not exist - '$method':'$path'"
			);
		}

		return ($entry) ? $entry : false;
	}

	public function sanitizePath($path)
	{
		$path = strtolower($path);
		$path = trim($path, '/');
		$path = preg_replace('/[\\/]+/', '/', $path);

		if(empty($path)) {
			$path = '/';
		}
		
		return $path;
	}
}