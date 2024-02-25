<?php

define('APP', dirname(__DIR__) . '/app/');

require_once APP . 'boot/init.php';


if(file_exists(APP . 'var/www/' . Request::get('id') . '.php')) {

	require_once(APP . 'var/www/templates/header.php');

	require_once(APP . 'var/www/' . Request::get('id') . '.php');

	require_once(APP . 'var/www/templates/footer.php');

} elseif( Session::exists('auth') ) {

    require_once(APP . 'var/www/templates/header.php');

	require_once(APP . 'var/www/terminal.php');

	require_once(APP . 'var/www/templates/footer.php');

} else {

    require_once(APP . 'var/www/templates/header.php');

	require_once(APP . 'var/www/login.php');

	require_once(APP . 'var/www/templates/footer.php');

}