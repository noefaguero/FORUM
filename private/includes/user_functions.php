<?php

include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/config_db.php';

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
function empty_field(){
    $errors = [];
    foreach ($_POST as $field => $value) {
        if($value == ""){
            array_push($errors, $field);
        }
    }
    return $errors;
}

function show_error($field, $errors){
    if(in_array($field, $errors)){
        return "form-control border-0 bg-danger-subtle";
    } else {
        return "form-control border-0 bg-light";
    }
}

function insert_user($username, $rol, $gender, $email, $pw){
    
    global $bd;
    
    try{
        //Prepared statement insert new user
        $sql = $bd->prepare("INSERT INTO users(names, rol, gender, email, pw) VALUES (?, ?, ?, ?, ?)");
        $sql->execute([$username, $rol, $gender, $email, password_hash($pw, PASSWORD_DEFAULT)]);
    } catch (Exception $e) {
        echo "Error en inserción en a la base de datos: " . $e->getMessage();
    }
    // Close the connection
    $bd = null;
    
}
