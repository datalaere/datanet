<?php

session_name('session_id');

session_start();

$session = [];

if( Session::exists('auth') ){

    $nickname = Session::get('nickname');

    $channel = Session::get('channel');

    $session['channel'] = APP . "sys/network/{$channel}.server";

    $session['user'] = APP . "etc/passwd/{$channel}/{$nickname}.user";

    $session['passwd'] = APP . "etc/passwd/{$channel}/";

    $session['log'] = APP . "var/system/{$channel}.{$nickname}.log";
      
    $user_ip = getVisitorIP();

    $date = getTimestamp();
      
    $data = '';
}
