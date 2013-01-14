<?php

namespace V\URL;
use \V\Core\Exception as CoreException;
use \V\URL\Exception as URLException;

class Router
{
	private $_routes = array(
		'GET' => array(),
		'POST' => array(),
		'PUT' => array(),
		'DELETE' => array(),
	);

	private $_types = array(
		':string' => '([a-zA-Z]+)',
		':int' => '([0-9]+)',
		':alpha' => '([a-zA-Z0-9]+)',
	);

	function __call($verb, $args)
	{
		if(sizeof($args) !== 2) {
			throw new CoreException\InvalidArgumentCount(
				__CLASS__,
				__METHOD__,
				2,
				sizeof($args)
			);
		}

		return $this->add($verb, $args[0], $args[1]);
	}

	public function add($verb, $path, $f)
	{
		$verb = $this->sanitizeVerb($verb);
		$path = $this->sanitizePath($path);

		// Stop override if volatile.
		$entry =& $this->_routes[$verb][$path];
		if(!is_callable($f)) {
			throw new URLException\RouteNotCallable(
				__CLASS__,
				__METHOD__,
				$verb,
				$path
			);
		}

		return ($entry = $f);
	}

	public function resolve($verb, $path)
	{
		$verb = $this->sanitizeVerb($verb);
		$path = $this->sanitizePath($path);

		if(isset($this->_routes[$verb][$path])) {
			$f =& $this->_routes[$verb][$path];
			return $f();
		}

		foreach($this->_routes[$verb] as $pattern => $f) {
			$pattern = strtr($pattern, $this->_types);
			
			if(preg_match('#^/?'.$pattern.'/?$#', $path, $matches)) {
				array_shift($matches);
				return call_user_func_array($f, $matches);
			}
		}

		throw new URLException\RouteNotFound(
			__CLASS__,
			__METHOD__,
			$verb,
			$path
		);
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

	public function sanitizeVerb($verb)
	{
		$verb = strtoupper($verb);
		
		// Default to GET if not volatile.
		if(!array_key_exists($verb, $this->_routes)) {
			$verb = 'GET';
		}

		return $verb;
	}
}