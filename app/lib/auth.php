<?php


   $input = filterInput(Request::get('input'), false);

   if( checkBlacklist(getVisitorIP(), APP . 'etc/hosts.deny') ) {
        echo '<br>ERROR: IP blacklisted. Login terminated!<br>';
        return false;
   }

   if($input == 'HOSTS' OR $input == 'NETSTAT') {
        $active_hosts = cmd_scan(APP . 'etc/hosts/'); 
        echo "<br><p>host (date)</p>";
        echo '_______________________________';
        foreach( $active_hosts as $host ):
            $date = date("F d, Y H:i", filemtime(APP . 'etc/hosts/'. $host));
            echo "<p>{$host}  ({$date})</p>";
        endforeach;

        return true;
    }

    if($input == 'HELP') {

        echo '<br>Connect to host with "LOGIN [host] [username]@[password]".<br>';

        return false;
    }

    $connection = cmd_connect($input, APP . 'etc/passwd/');

        if(!$connection) {

            echo '<br>Missing parameters OR non-alphanumeric credentials. <br> Connect to host with "LOGIN [host] [username]@[password]".<br>';

            return false;

        }


        $username = Session::get('username');

        $host = Session::get('host');

        $session['host'] = APP . "etc/hosts/{$host}/sys/motd";

        $session['bin'] = APP . "etc/hosts/{$host}/bin";

        $session['username'] = APP . "etc/hosts/{$host}/home/{$username}";

        $session['passwd'] = APP . "etc/hosts/{$host}/sys/passwd";

        $session['log'] = APP . "etc/hosts/{$host}/sys/system.log";
          
        $user_ip = getVisitorIP();

        $date = getTimestamp();
          
        $data = '';

if(file_exists($session['host'])) {

        $data = file_get_contents($session['host']);

        if(!$data) {
          
            session_destroy();

            checkBlacklist(getVisitorIP(), APP . 'etc/hosts.deny', true);
          
            echo '<br>ERROR: Wrong credentials. Login terminated!<br>';

            return false;
        }
    }
    
if(file_exists($session['username'])) {

            $user = unserialize(file_get_contents($session['passwd'] . '/' . $username));


            if(password_verify(Session::get('password'), $user['password'])) {

               $color = $user['color'];

                $data .= "<div user='{$username}' $color class='response'>[" . $date . "] <b>". $username ."</b> (". $user_ip .") conntected to {$host}.<br></div>". PHP_EOL;

                //Simple welcome message
                file_put_contents($session['host'], $data);

                unset($data);

                Session::put('color', $color);

                Session::put('auth', true);

                logger("{$username} connected to {$host}.", $session['log']);

                echo 'ok';

                return true;

            } else {

                if( !Session::get('token') ) {

                    Session::put('token', 1);

                }

                $token = Session::get('token');
                

                if( $token ) {

                    Session::put('token', $token+1);

                    if($token == 4) {

                        session_destroy();

                        checkBlacklist(getVisitorIP(), APP . 'etc/hosts.deny', true);

                        echo 'error';

                        return false;
                    }

                }

                echo "<br>ERROR: Invalid credentionals. Please try again or create new user. {$token} failed attempts out of 3<br>";

                return false;
            }
      }


        $session_data = [
            'id' => uniqid($user_ip),
            'date' => getTimestamp(),
            'ip' => $user_ip,
            'username' => filterInput(Session::get('username'), true),
            'password' => password_hash(Session::get('password'), PASSWORD_DEFAULT),
            'host' => filterInput(Session::get('host'), true),
            'color' => setColor(),
        ];

            if ( !file_exists($session['username']) ) {
                
                mkdir($session['username'], 0777, true);
            }
          
            if ( !file_exists($session['passwd']) ) {

                mkdir($session['bin'], 0777, true);
          
                mkdir($session['passwd'], 0777, true);
            }

        file_put_contents($session['passwd'] . "/{$username}", serialize($session_data));

        $color = $session_data['color'];

        //Simple welcome message
        if(!file_exists($session['host'])) {
            $data .= "<div user='system' class='response'>Welcome to {$host} <br><br> UNAUTHORIZED ACCESS TO THIS DEVICE IS PROHIBITED <br><br> You must have explicit, authorized permission to access or configure this device. Unauthorized attempts and actions to access or use this system may result in civil and/or criminal penalties. All activities performed on this device are logged and monitored.<br><br></div>". PHP_EOL;
        }

        $data .= "<div user='{$username}' $color class='response'>[" . $date . "] <b>". $username ."</b> (". $user_ip .") connected to {$host}.<br></div>". PHP_EOL;

        file_put_contents($session['host'], $data);

        unset($data);

        Session::put('auth', true);

        Session::put('color', $color);

        logger("{$username} connected to {$host}.", $session['log']);

        echo 'ok';

        return true;