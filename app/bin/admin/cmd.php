<?php

if($input == 'CLEAR') {

        $data = '';

        $input = "MOTD cleared by @{$username}.";
  
        $username = 'system';
}

if($input == 'RESET') {

  $data = preg_replace("/<div user='system' [^>]*>.*?<\/div>/", '', $data);

  file_put_contents($session['host'], $data);

  $data = false;
}


if($input == 'SCAN') {

  $input .= explode(" ", $input)[1];
  
}
