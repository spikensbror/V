<?php

// ------------------------------------------------------------------------- \\
// ___       ___ ___________________________________________________________ \\
// \  \     /  /                                                           / \\
//  \  \   /  /   V-Engine                                                /  \\
//   \  \ /  /   --------                                                /   \\
//    \  V  /   A really lightweight, easy to use and modular           /    \\
//     \   /   all-purpose PHP library.                                /     \\
//      \_/___________________________________________________________/      \\
//                                                                           \\
// ------------------------------------------------------------------------- \\

// Require autoload.
require_once 'vendor/autoload.php';

// V-Engine loader and global accessor function.
function v($module)
{
	// Static module buffer.
	static $modules = array();

	// Trim module name from backslashes and make it lower-case,
	// get entry from buffer and return it if it is already buffered.
	$module = strtolower(trim($module, '\\'));
	$entry =& $modules[$module];
	if($entry !== null) {
		return $entry;
	}

	// Create class name and throw exception if it doesn't exist and the engine
	// is defined as volatile, otherwise just set buffer to false and return.
	$class = "V\\$module\\Module";
	if(!class_exists($class)) {
		throw new \V\Core\Exception\ModuleNotFound(
			'Global',
			__FUNCTION__,
			$module
		);
	}

	// Instantiate module.
	return ($entry = new $class());
}