<?php

session_name('session_id');

session_start();

$session = [];

if( Session::exists('auth') ){

    $username = Session::get('username');

    $host = Session::get('host');

    $session['host'] = APP . "etc/hosts/{$host}/sys/motd";

    $session['username'] = APP . "etc/hosts/{$host}/home/{$username}";

    $session['passwd'] = APP . "etc/hosts/{$host}/sys/passwd";

    $session['log'] = APP . "etc/hosts/{$host}/sys/system.log";
      
    $user_ip = getVisitorIP();

    $date = getTimestamp();
      
    $data = '';
}
