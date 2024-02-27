<?php

require_once APP . 'sys/config.php';

spl_autoload_register(function($class) {
    require_once APP . 'usr/' . $class . '.php';
});

require APP . 'boot/functions.php';
require APP . 'boot/session.php';
require APP . 'boot/cmd.php';

lastVisit();