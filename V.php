<?php

// Require autoload.
require_once 'vendor/autoload.php';

// V-Engine loader and global accessor function.
function v($module)
{
	static $modules = array();

	$module = trim($module, '\\');
	$entry =& $modules[$module];
	if($entry !== null) {
		return $entry;
	}

	$class = "V\\$module\\Module";
	if(!class_exists($class)) {
		return ($entry = false);
	}

	return ($entry = new $class);
}