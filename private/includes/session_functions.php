<?php

define("EXTENDED", 3600);
define("SHORT", 300);
   
/**
 * Set the cookie of the session duration
 * 
 * @param integer $duration The session duration in seconds
 */
function set_session_option($duration = SHORT){

    setcookie("session_option", $duration , time()+604800 ,"/"); 
}


/**
 * Function to check if the user has been inactive for more than 5 minutes or 1 hour
 * 
 * @param integer $last_activity Last time of activity user  
 *
 */
function check_inactivity($last_activity){
    //Save the actual date
    $current_time = time();
    
    if(isset($_COOKIE["session_option"]) &&  $_COOKIE["session_option"] == EXTENDED){
        $duration = EXTENDED;
    }else{
        $duration = SHORT;
    }
    
    //if time of inactivity is higher than 5 minutes or 1 hour the session is closed
    if(($current_time - $last_activity) >= $duration) {
        // clean the session array
        $_SESSION = array();
        // destroy the session
        session_destroy();
        // delete the session cookie
        setcookie(session_name(),"", time()-1000,"/");
        
        header("Location: ../../index.php?timePass=TRUE");
 
    } else {
        $_SESSION["last_activity"] = $current_time;
    }
}