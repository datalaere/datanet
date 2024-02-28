<?php

// Commands
function cmd_scan($dir)
{
    return array_values(array_diff(scandir($dir), array('..', '.')));
}


function cmd_connect($input, $storage = '') {

    $connection = [];

    if( preg_match('/LOGIN/', $input) OR preg_match('/LOGIN/', $input) OR preg_match('/NEWUSER/', $input) OR preg_match('/CONNECT/', $input)) {
        
                $input = explode(' ', $input);

                if(count($input) == 1) {

                    return false;
                }

                if(!preg_match('/^[a-z]+[a-z0-9._]+$/', $input[1]) OR !preg_match('/^[a-z]+[a-z0-9._]+$/', explode('@', $input[2])[0]) OR !preg_match('/^[a-z]+[a-z0-9._]+$/', explode('@', $input[2])[1])) {

                    return false;
                }

                                
               /**
                * 0 = CMD
                * 1 = #channel
                * 2 = nickname@password
                * 3 = key
                */

                if(count($input) == 3) {

                    $connection['host'] = $input[1];
                    $connection['username'] = explode('@', $input[2])[0];
                    $connection['password'] = explode('@', $input[2])[1];
                    $connection['key'] = false;
                }

                if(count($input) == 4) {

                    $connection['host'] = $input[1];
                    $connection['username'] = explode('@', $input[2])[0];
                    $connection['password'] = explode('@', $input[2])[1];                  
                    $connection['key'] = md5($input[3]);

                }

                if( !isset($connection['username']) ||  !isset($connection['host']) ) {

                    return false;
                }

        $connection['session_id'] = uniqid();

        $connection['ip'] = getVisitorIP();

        foreach($connection as $key => $value) {
            Session::put($key, $value);
        }
        
        return $connection;  
                
     }

     return false;

}