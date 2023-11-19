<?php

//Check if have send data 
if( $_SERVER['REQUEST_METHOD']=='POST' ){
    
    //Check al variables has values
    
    //name
    if(isset($_POST['name']) ){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    }
}
else {//If not info sended then redirect to the main page with variable redirected
    header('Location: ../../public_html/index.php?redirected=true');
}
