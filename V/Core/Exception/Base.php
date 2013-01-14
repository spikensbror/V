<?php

namespace V\Core\Exception;

abstract class Base extends \Exception
{
	private $_class = '';
	private $_method = '';
	private $_string = '';
	private $_time = 0;

	function __construct($class, $method, $message)
	{
		// Construct original exception data.
		parent::__construct($message);

		// Assign custom exception data.
		$this->_class = $class;
		$this->_method = $method;
		$this->_string = "[$class - $method()]: $message";
		$this->_time = time();
	}

	public function getClass()
	{
		return $this->_class;
	}

	public function getMethod()
	{
		return $this->_method;
	}

	public function getTime($format = null)
	{
		// If format is specified, return date formatted time, otherwise
		// return regular timestamp.
		return ($format) ? date($format, $this->_time) : $this->_time;
	}

	public function toString($timestamp = false)
	{
		return (($timestamp) ? '('.$this->getTime($timestamp).') - ' : '').
			$this->_string;
	}
}