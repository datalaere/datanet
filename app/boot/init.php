<?php

define('APP_NAME', 'DATANET');

ini_set('display_errors', 1);

date_default_timezone_set('Europe/Copenhagen');

spl_autoload_register(function($class) {
    require_once APP . 'usr/' . $class . '.php';
});

require APP . 'boot/functions.php';
require APP . 'boot/session.php';

lastVisit();