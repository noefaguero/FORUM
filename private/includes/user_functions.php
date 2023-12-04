<?php

/**
 * Check the user keys
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
            
            // Start the session and its values
            session_start();
            
            // Save values of the user
            $_SESSION["user"] = $user[0];
            $_SESSION["rol"] = $user[3];
            $_SESSION["id"]=$user[4];
            return true;
        }
    }
    //If any of them is correct returns false
    return false;
}

/**
 * Check empty fiedls.
 * 
 * @return array Empty fields.
 */
function empty_field(){
    $errors = [];
    foreach ($_POST as $field => $value) {
        if($value == ""){
            array_push($errors, $field);
        }
    }
    return $errors;
}

/**
 * Highlight empty fields in red.
 * 
 * @param string $field Field to check.
 * @param array $errors Array of empty fields.
 * @return string Bootstrap classes for the style.
 */
function show_error($field, $errors){
    if(in_array($field, $errors)){
        return "form-control border-0 bg-danger-subtle";
    } else {
        return "form-control border-0 bg-light";
    }
}

/**
 * Check the color theme.
 * 
 * @param string $cookie Value of the theme cookie
 * @return string Path to the stylesheet.
 */ 
function check_theme($cookie){
    if(isset($cookie)){
        $string = htmlspecialchars($cookie);
        return "../../css/$string.css";
    }
}