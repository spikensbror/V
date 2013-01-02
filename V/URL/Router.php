<?php

namespace V\URL;

class Router
{
	private $_routes = array();
	protected $parent = '';

	function __construct($parent)
	{
		$this->parent = $parent;
	}

	public function add($method, $path, $f)
	{
		$path = $this->sanitizePath($path);
		return ($this->_routes[$method][$path] = $f);
	}

	public function get($method, $path)
	{
		$path = $this->sanitizePath($path);
		$entry =& $this->_routes[$method][$path];
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