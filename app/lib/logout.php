<?php
  
    if (file_exists($session['host'])) {


      $data = file_get_contents($session['host']);

      $username = Session::get('username');

      $host = Session::get('host');

      $ip = Session::get('ip');

      if($data) {

            $color = Session::get('color');

              $data .= "<div user='{$username}' $color class='response'>[" . getTimestamp(false) . "] <b>". $username ."</b> (". $ip .") disconnected from {$host}.<br></div>". PHP_EOL;

              file_put_contents($session['host'], $data);

              unset($data);

      }
    }

    logger("{$username} disconnect from {$host}.", $session['log']);

    session_destroy();

    return header("Location: index.php?id=login"); //Redirect the user