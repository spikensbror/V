<?php

namespace V\URL;

class Router extends \V\Core\BaseClass
{
	private $_routes = array();

	private $_types = array(
		':string' => '([a-zA-Z]+)',
		':int' => '([0-9]+)',
		':alpha' => '([a-zA-Z0-9]+)',
	);

	private $_verbs = array(
		'GET',
		'POST',
		'PUT',
		'DELETE',
	);

	function __call($verb, $args)
	{
		if(sizeof($args) !== 2) {
			throw new \V\Core\Exception(
				__CLASS__,
				__METHOD__,
				'Expected 2 arguments, got '.sizeof($args).'.'
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
		if($entry && $this->isVolatile()) {
			throw new \V\Core\Exception(
				__CLASS__,
				__METHOD__,
				"Route already exists - '$verb':'$path'"
			);
		}

		return ($entry = $f);
	}

	public function raw($verb, $path)
	{
		$verb = $this->sanitizeVerb($verb);
		$path = $this->sanitizePath($path);

		$entry =& $this->_routes[$verb][$path];
		if($entry) {
			return $entry;
		}

		$result = array();
		foreach($this->_routes[$verb] as $pattern => $f) {
			$pattern = strtr($pattern, $this->_types);
			if(preg_match('#^/?'.$pattern.'/?$#', $path, $matches)) {
				unset($matches[0]);
				$result['f'] = $f;
				$result['args'] = $matches;
				break;
			}
		}

		if($this->isVolatile() && !$result['f']) {
			throw new \V\Core\Exception(
				__CLASS__,
				__METHOD__,
				"Route does not exist - '$verb':'$path'"
			);
		}

		return $result;
	}

	public function resolve($verb, $path)
	{
		$raw = $this->raw($verb, $path);
		if(!is_array($raw)) {
			return $raw();
		}

		return call_user_func_array($raw['f'], $raw['args']);
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
		if(!in_array($verb, $this->_verbs)) {
			if($this->isVolatile()) {
				throw new \V\Core\Exception(
					__CLASS__,
					__METHOD__,
					"Verb does not exist - '$verb'"
				);
			}

			// Default to GET if not volatile.
			$verb = 'GET';
		}

		return $verb;
	}
}