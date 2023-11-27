<?php

include "../includes/user_functions.php";

//Check if the data has been sent
if( $_SERVER['REQUEST_METHOD']=='POST' ){

    $error = "";
    $fields = ["rol", "username", "email", "pw"];
    
    $error .= empty_field(...$fields);
    
    
     if($error === ""){
        if (filter_field("pw1") === filter_field("pw2")){
            header('Location: ../../public_html/index.php');
            insert_user(
                filter_field("rol"), 
                filter_field("username"), 
                filter_field("genre"), 
                filter_field("email"), 
                filter_field("pw")
            );
        } else {
            header('Location: ../../public_html/index.php?pw=false');
        }
    } else {
        $error = substr($error, 0, -1);
        header("Location: ../../index.php?$error");
   
    }
    
}