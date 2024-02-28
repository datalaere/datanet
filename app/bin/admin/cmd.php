<?php

if($input == 'RESET') {

        $data = "<div user='system' class='response'>Welcome to {$host} <br><br> UNAUTHORIZED ACCESS TO THIS DEVICE IS PROHIBITED <br><br> You must have explicit, authorized permission to access or configure this device. Unauthorized attempts and actions to access or use this system may result in civil and/or criminal penalties. All activities performed on this device are logged and monitored.<br><br></div>". PHP_EOL;

        $input = "Session reset by @{$username}.";
  
        $username = 'system';
}

if($input == 'REBOOT') {

  $data = preg_replace("/<div user='system' [^>]*>.*?<\/div>/", '', $data);

  file_put_contents($session['host'], $data);

  $data = false;
}
