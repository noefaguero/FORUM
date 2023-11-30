<?php

include './config_db.php';

/**
 * 
 * @param array $users //Line of the database with the information
 * @param String $inputName //Name introduced to search
 * @param String $inputKey  //Key to search
 * @return bool //If the user is correct returns true else returns false
 */
function check_user($users, $inputName, $inputKey){
    // Loop through the array returned by the query
    foreach ($users as $user) {
        
        //If the statement is True it returns true
        if ( ($user["names"] == strtolower($inputName) || $user["email"] == strtolower($inputName)) && password_verify($inputKey, $user['pw']) ) {
            
//            Start the session and its values
            session_start();
            
//            Save values of the user
            $_SESSION["user"] = $user[0];
            $_SESSION["email"] = $user[1];
            $_SESSION["rol"] = $user[3];
            $_SESSION["id"]=$user[4];
            return true;
        }
    }
    //If any of them is correct returns false
    return false;
}

//Check if some variable is empty
function empty_field($field){
    if(!isset($_POST[$field])){
        return "$field=false&";
    }
}

function filter_field($field){
    return filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
}
    
function insert_user($rol, $username, $genre, $email, $pw){
    
    //Prepared statement insert new user
    $sql = $bd->prepare("INSERT INTO users(rol, names, genre, email, pw) VALUES (?, ?, ?, ?, ?)");
    $sql->execute($rol, $username, $genre, $email, $pw);
}
