<?php

if($input == '/clear') {

        $data = '';

        $input = "<i>channel cleared by @{$nickname}.</i>";
  
        $nickname = 'system';
}

if($input == '/reset') {

  $data = preg_replace("/<div user='system' [^>]*>.*?<\/div>/i", '', $data);
      
  $data = $dec->encrypt($data);

  file_put_contents($session['channel'], $data);

  $data = false;
}


if($input == '/scan') {

  $input .= explode(" ", $input)[1];
  
}
