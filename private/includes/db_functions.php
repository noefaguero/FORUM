<?php

/*************************** DATABASE CONNECTION ******************************/

$db = null;

/**
 * Create the connection to the database
 * 
 * @global PDO $db Connection to the database
 */
function db_connect() {
    
    global $db;
    $conn_string = "mysql:dbname=FORUM;host=127.0.0.1";
    $user_db = "root";
    $key = "";

    try {
        $db = new PDO($conn_string, $user_db, $key);

    } catch (Exception $e) {
        echo "Error en la conexión con la base de datos" . $e->getMessage();
    }
}

/**
 * Close the connection to the database
 * 
 * @global PDO $db Connection to the data base
 */
function db_disconnect() {
    global $db;
    $db = null;
}

/******************************** FOR LOG IN **********************************/

function user_exist($inputUser, $inputKey) {
    global $db;
    try{
        //Prepared statement to select a user
        $sql=$db->prepare("SELECT id_user, names, rol, pw FROM users WHERE email = ? OR names = ?;");
        //Execute the query
        $sql->execute([strtolower($inputUser), strtolower($inputUser)]);
        
        $user = $sql->fetch();
     
        if($user && password_verify($inputKey, $user[3])){
                session_start();
                $_SESSION["id"] =  $user[0];
                $_SESSION["name"] =  $user[1];
                $_SESSION["rol"] = $user[2];
                $match = true;
        } else {
            $match = false;
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
        $match = false;
    }
    return $match;
}           

/******************************* FOR SING UP **********************************/

/**
 * 
 * @global PDO $db Connection to the data base
 * @param string $username Name of the user
 * @param string $rol Rol of the user
 * @param string $gender Gender of the user
 * @param string $email Email of the user
 * @param string $pw Password of the user
 */
function insert_user($username, $rol, $gender, $email, $pw){
    global $db;
    try{
        //Prepared statement to insert a new user
        $sql = $db->prepare("INSERT INTO users(names, rol, gender, email, pw) VALUES (?, ?, ?, ?, ?)");
        $sql->execute([$username, $rol, $gender, $email, $pw]);
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }
}

/******************************** FOR ASIDE ***********************************/

/**
 * Count the rows of a table
 * 
 * @global PDO $db Connection to the data base
 * @param string $table Table from which records are counted
 */
function records_count($table){
    global $db;
    try{
        // Prepared statement to count the records of a table
        $sql = $db->prepare("SELECT COUNT(*) FROM $table;");
        // Execute the query
        $sql->execute();
        $num = $sql->fetch();
            return $num[0];
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }
}

