<?php 

define('APP', dirname(__DIR__) . '/app/');


// Load sys
require APP . 'boot/init.php';

// Load modules
require APP . 'usr/Encryptor.php';


if(Request::get('input') && Request::get('action') == 'login'){

	// Load login script
	require APP . 'lib/auth.php';
}

if(Session::exists('auth') && Request::get('action') == 'input'){

	// Load input script
	require APP . 'lib/input.php';
}

if(Request::get('action') == 'request'){

	// Load request script
	require APP . 'lib/request.php';
}

if(Session::exists('auth') && Request::get('action') == 'logout'){ 

	// Load logout script
	require APP . 'lib/logout.php';
}


