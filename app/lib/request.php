<?php

    
	if (isset($session['host']) && file_exists($session['host'])) {

       $data = file_get_contents($session['host']);
       
        if(!is_null($data)) {

            echo $data;
    
            unset($data);

        } else {
          
            echo "<div  class='response'>(".date('H:i:s').") <b>".'system'."</b>: ERROR. Please contact sysadmin!<br></div>";
          
        }
      
    } else {
        
      require APP . "var/www/welcome.php";
    } 


   

