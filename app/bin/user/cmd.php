<?php

if($input == 'CLEAR') {

	$data = preg_replace("/<div user='{$host}' [^>]*>.*?<\/div>", '', $data);

    file_put_contents($session['host'], $data);

    $data = false;
}


if($input == 'HELP') {

	    $username = 'system';

        $input = '<br>CLEAR - clear your comments.';

        $input .= '<br>DC - disconnect from host.<br>';
  
}
