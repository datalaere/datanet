<?php


   $input = filterInput(Request::get('input'), false);

   if( checkBlacklist(getVisitorIP(), APP . 'etc/blacklist') ) {
        echo '<br>ERROR: IP in blacklist. Login terminated!<br>';
        return false;
   }


    if($input == 'help') {

        echo '<br>Use "/login [server] [username]@[password] (private key)" to join server.<br>';

        return false;
    }

        $connection = cmdJOIN($input, APP . 'etc/passwd/');

        if(!$connection) {

            echo '<br>Missing parameters. Use "/login [server] [username]@[password] (private key)" to join server.<br>';

            return false;

        }


    if(Session::get('key'))  {

        $dec = new Encryptor(Session::get('key'));  

    } else {

        $dec = new Encryptor(false);

    }


        $nickname = Session::get('nickname');

        $channel = Session::get('channel');

        $session['channel'] = APP . "sys/network/{$channel}.server";

        $session['user'] = APP . "etc/passwd/{$channel}/{$nickname}.user";

        $session['passwd'] = APP . "etc/passwd/{$channel}/";

        $session['log'] = APP . "var/system/{$channel}.{$nickname}.log";
          
        $user_ip = getVisitorIP();

        $date = getTimestamp();
          
        $data = '';

if(file_exists($session['channel'])) {
        $data = $dec->decrypt(file_get_contents($session['channel']));

        if(!$data) {
          
            session_destroy();

            checkBlacklist(getVisitorIP(), APP . 'etc/blacklist', true);
          
            echo '<br>ERROR: Wrong credentials. Login terminated!<br>';

            return false;
        }
    }
    
    if(file_exists($session['user'])) {

            $user = unserialize(file_get_contents($session['user']));


            if(password_verify(Session::get('password'), $user['password'])) {

               $color = $user['color'];

                $data .= "<div user='{$nickname}' $color class='response'><i>[" . $date . "] <b>". $nickname ."</b> (". $user_ip .") joined server.</i><br></div>". PHP_EOL;

                //Simple welcome message
                $data = $dec->encrypt($data);

                file_put_contents($session['channel'], $data);

                unset($data);

                Session::put('color', $color);

                Session::put('auth', true);

                logger("{$nickname} joined channel.", $session['log']);

                echo 'ok';

                return true;

            } else {
              
                if($input == 'exit'){
                    session_destroy();
                    echo 'error';
                    return false;
                }

                if( !Session::get('token') ) {

                    Session::put('token', 1);

                }

                $token = Session::get('token');
                

                if( $token ) {

                    Session::put('token', $token+1);

                    if($token == 4) {

                        session_destroy();

                        checkBlacklist(getVisitorIP(), APP . 'etc/blacklist', true);

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
            'joined' => getTimestamp(),
            'ip' => $user_ip,
            'nickname' => filterInput(Session::get('nickname'), true),
            'password' => password_hash(Session::get('password'), PASSWORD_DEFAULT),
            'channel' => filterInput(Session::get('channel'), true),
            'color' => setColor(),
        ];

          
            if ( !file_exists($session['passwd']) ) {
          
                mkdir($session['passwd'], 0777, true);
            }

        file_put_contents($session['user'], serialize($session_data));

        $color = $session_data['color'];

        //Simple welcome message
        $data .= "<div user='{$nickname}' $color class='response'><i>[" . $date . "] <b>". $nickname ."</b> (". $user_ip .") joined server.</i><br></div>". PHP_EOL;


        $data = $dec->encrypt($data);


        file_put_contents($session['channel'], $data);

        unset($data);

        Session::put('auth', true);

        Session::put('color', $color);

        logger("{$nickname} joined server.", $session['log']);

        echo 'ok';

        return true;