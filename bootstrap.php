<?php

	if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
	if(!defined('DR')) define('DR', dirname(__FILE__) . DS);
	if(!defined('AM')) die('AM undefined');

	spl_autoload_register(function($class) {

		$filepath = DR . 'library' . DS . str_replace('\\', DS, $class) . '.inc.php';
		if(is_file($filepath)) include($filepath);

	});

	new main;
