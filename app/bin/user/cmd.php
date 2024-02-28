<?php
/*
if($input == 'CLEAR') {

	  $data = preg_replace("/<div user='{$username}' [^>]*>.*?<\/div>", '', $data);

    file_put_contents($session['host'], $data);

}
*/

if($input == 'LS') {

    $input = explode(" ", $input)[1];
  
    $host = APP . "etc/hosts/" . Session::get('host') . "/home/" . Session::get('username') . '/' . $input;
    
    $input = implode(' ', cmd_scan($host));
  
  }

  if($input == 'USERID') {

    $input = Session::get('session_id');

}

if($input == 'IP') {

  $input = Session::get('ip');

}

if($input == 'DATE') {

  $input = Session::get('date');

}


if($input == 'HELP') {

	    $username = 'system';

        $input = '<br>CLEAR - clear your comments.';

        $input .= '<br>DC - disconnect from host.<br>';
  
}
