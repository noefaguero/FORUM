<?php
/**
 * Function to check if the person using the page has been inactive for more than 10 minutes
 * 
 * @param type $lastConnection //Last time that user connected
 * @return type //If time has passed redirectionates to index else returns the actual date
 */
function checkInactivityTimePassed($lastConnection){
    //Save the actual date
    $dateNow = date("d-m-Y H:i:s");
    //calculate the time has passed
    $transcurrentTime = (strtotime($dateNow)-strtotime($lastConnection) );
    
    //if time is higher than 10 minutes it closes the session
    if($transcurrentTime >= 600) {
      session_destroy(); 
      header("Location: ../../index.php?timePass=TRUE");
    }
    else{
        //If time has no passed then it actualises the time
        return $dateNow;
    }
}

