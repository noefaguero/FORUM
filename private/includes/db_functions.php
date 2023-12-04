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
        $result = $sql->fetch();
            return $result[0];
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }
}

/***************************** FOR SUBSCRIBER *********************************/

function get_array($query, $key){
    global $db;
    try{
        $sql = $db->prepare($query);
        $sql->execute([$key]);
        $result =  $sql->fetchAll();
        $output = array();
        
        if ($result) {
            foreach ($result as $row) {
                $output[$row[0]] = $row[1];
            }
        }
        return $output;
    
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}

function thread_group_by($query, $key){
    global $db;
    try{
        $sql = $db->prepare($query);
        $sql->execute([$key]);
        $result =  $sql->fetchAll();
        if ($result) {
            $output = '';
            foreach ($result as $row) {
                $output .= '<a href="./threads.php?thread='. $row[2] .'" class="color-link" >' . $row[0] . '</a><br><p>' . $row[1] . '</p>';
            }
            return $output;
        } else {
            return '<p>No hay resultados</p>';
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}

function comment_group_by($query, $thread, $subscriber = null){
    global $db;
    try{
        $sql = $db->prepare($query);
        
        if($subscriber){
            $sql->execute([$subscriber, $thread]);
        } else {
            $sql->execute([$thread]);
        }
        
        $result =  $sql->fetchAll();
        if ($result) {
            $output = '';
            foreach ($result as $row) {
                $output .= '<div class="alert alert-light m-3" role="alert"><span class="fw-bold">' . $row[1] . '</span><p>' . $row[0] . '</p></div>';
            }
            return $output;
        } else {
            return '<p>No hay resultados</p>';
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}

function show_thread($id){
    global $db;
    try{
        $sql = $db->prepare("SELECT title, body FROM threads WHERE id_thread=?;");
        $sql->execute([$id]);
        $result =  $sql->fetch();
        if ($result) {
            $output = '<h2>'.$result[0].'</h2><br><p>'.$result[1].'</p>';
            return $output;
        } else {
            return '<p>El tema seleccionado no existe</p>';
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}

//*****************FOR EDITOR*****************************

/**
 * Function to count the number of threads of a table
 * 
 * @global PDO $db //BD
 * @param String $table //Name of a table of the db
 * @return //returns the number of columns
 */
function show_numThreads($table, $idUser){
    global $db;
    try{
        trim($idUser);
        // Prepared statement to count the records of a table
        $sql = $db->prepare("SELECT COUNT(*) FROM $table WHERE id_user=?;");
        $sql->bindParam(1, $idUser );
        
        // Execute the query
        $sql->execute();
        $result = $sql->fetch();
        
        return $result[0];
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }
}

/**
 * Function to create the threads
 * 
 * @global PDO $db
 * @param type $query
 * @param type $key
 * @return string
 */
function thread_group_by_editor($query, $key){
    global $db;
    try{
        $sql = $db->prepare($query);
        $sql->execute([$key]);
        $result =  $sql->fetchAll();
        if ($result) {
            $output = '';
            foreach ($result as $row) {
                $output .= '<a href="./threadsEditor.php?thread='. $row[2] .'" class="color-link" >' . $row[0] . '</a><br><p>' . $row[1] . '</p>';
            }
            return $output;
        } else {
            return '<p>No hay resultados</p>';
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}
