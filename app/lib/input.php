<?php

    $input = filterInput(Request::get('input'));

    $username = Session::get('username');


    $data = file_get_contents($session['host']);

    // Special commands
    if($username == 'admin' || $username == 'root') {
    
        require_once APP . 'bin/admin/cmd.php';

    }

    require_once APP . 'bin/user/cmd.php';

    if($data !== false) {

        $color = Session::get('color');

        $data .= "<div user='{$username}' $color class='response'>[".getTimestamp(false)."] <b>".$username."</b>: ". $input ."<br></div>" . PHP_EOL;

        file_put_contents($session['host'], $data);

        unset($data);

    }