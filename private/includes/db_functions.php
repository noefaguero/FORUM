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
 * @global PDO $db Connection to the database
 */
function db_disconnect() {
    global $db;
    $db = null;
}

/******************************** FOR LOG IN **********************************/

/**
 * Check if a user and password match
 * 
 * @global PDO $db Connection to the data base
 * @param string $inputUser Input of the user name or email
 * @param string $inputKey Input of the password
 * @return boolean 
 */
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
 * @global PDO $db Connection to the database
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

/******************************* FOR ASIDE ************************************/

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

/*************************** SUBSCRIBER SELECTIONS ****************************/

/**
 * Get an array from a query
 * 
 * @global PDO $db Connection to the database
 * @param string $query Database query statement
 * @param mixed $key Filtering parameter.
 * @return array Array with the elements.
 */
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

/**
 * Group the threads
 * 
 * @global PDO $db Connection to the database
 * @param string $query Database query statement
 * @param mixed $key Thread category of the editor ID
 * @return string
 */
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

/**
 * Group the comments.
 * 
 * @global PDO $db Connection to the database
 * @param string $query Database query statement
 * @param integer $thread ID of the thread.
 * @param integer $subscriber ID of the subscriber
 * @return string HTML code with the content of the comments.
 */
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
                if($row[1] == $_SESSION["name"]){
                    $output .= 
                        '<div class="alert alert-light m-3" role="alert">
                            <span class="fw-bold">' . $row[1] . '</span>
                            <p>' . $row[0] . '</p>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary body" data-bs-toggle="modal" data-bs-target="#update'. $row[2] .'">
                                    <i class="fa-solid fa-pen text-white"></i>
                                </button>
                                
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#remove'. $row[2] .'">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </button>
                            </div>
                        </div> 
                        <div class="modal fade" id="remove'. $row[2] .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Seguro que quieres eliminar este comentario?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="../../../private/handlers/comments_handlers/remove_comment.php" method="POST">
                                            <input type="hidden" name="id_remove" value="'. $row[2] .'">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Sí</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="modal fade" id="update'. $row[2] .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar comentario</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../../../private/handlers/comments_handlers/update_comment.php" method="POST" class="row">
                                            <input type="hidden" name="id_update" value="'. $row[2] .'">
                                            <textarea name="newcomment" rows="5" cols="10">'. $row[0] .'</textarea>
                                            <button type="submit" class="btn btn-secondary body mt-3 text-white" data-bs-dismiss="modal">Guardar</button>
                                        </form>
                                    </div>
                                    
                                </div>
                           </div>
                        </div>';

                } else {
                    $output .= '<div class="alert alert-light m-3" role="alert">
                                    <span class="fw-bold">' . $row[1] . '</span>
                                    <p>' . $row[0] . '</p>
                                </div>';
                } 
            }
            return $output;
        } else {
            return '<p>No hay resultados</p>';
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }      
}

/**
 * Show a thread.
 * 
 * @global PDO $db Connection to the database
 * @param string $id ID of the thread to show.
 * @return string The content of the thread.
 */
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

/****************************** INSERT COMMENT ****************++***************/

/**
 * Insert a new comment.
 * 
 * @global PDO $db Connection to the database
 * @param string $newcomment The body of the new comment.
 * @param integer $id_thread ID of the thread.
 * @param integer $id_user ID of the user.
 */
function insert_comment($newcomment, $id_thread, $id_user){
    global $db;
    try{
        $sql = $db->prepare("INSERT INTO comments(comment, id_thread, id_user) VALUES(?, ?, ?);");
        $sql->execute([$newcomment, $id_thread, $id_user]);
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }  
}

/****************************** UPDATE COMMENT *********************************/

/**
 * Update the body of a comment
 * 
 * @global PDO $db Connection to the database
 * @param string $newcomment The body of the comment
 * @param integer $id_comment ID of the comment
 */
function update_comment($newcomment, $id_comment){
    global $db;
    try{
        $sql = $db->prepare("UPDATE comments SET comment = $newcomment WHERE id_comment=? ;");
        $sql->execute([$id_comment]);
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
    }  
}

/**************************** DELETE COMMENT **********************************/

/**
 * 
 * @global PDO $db Connection to the database
 * @param type $id_comment
 */
function delete_comment($id_comment){
    global $db;
    try{
        $sql = $db->prepare("DELETE FROM comments WHERE id_comment=? ;");
        $sql->execute([$id_comment]);
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
 * Function to count the number of threads of a table
 * 
 * @global PDO $db //BD
 * @param String $table //Name of a table of the db
 * @return //returns the number of columns
 */
function show_numComments($idUser){
    global $db;
    try{
        trim($idUser);
        // Prepared statement to count the records of a table
        $sql = $db->prepare("SELECT COUNT(*) FROM `comments` JOIN `threads` ON comments.id_thread = threads.id_thread WHERE threads.id_user=?;");
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
