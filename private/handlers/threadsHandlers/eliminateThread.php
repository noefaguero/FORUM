<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/Forum/private/includes/db_functions.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Forum/private/includes/session_functions.php';

    session_start();
    if (!isset($_SESSION["name"])) {
        header("Location: ../../index.php?redirected=true");
    }

    if (isset($_SESSION["last_activity"])) {
        check_inactivity($_SESSION["last_activity"]);
    }
    
    
    //If there havent been any value sended it will return
    if($_SERVER["REQUEST_METHOD"]==='GET'){
        
        //if no data in get returns
        if(!isset($_GET["idThread"]) ){
            header("Location: ../../../public_html/pages/editor/listModifiePage.php?redirected=true");   
        }
        
        //Save the variables that we will use in the future statements
        $idThread=htmlspecialchars($_GET["idThread"]);
        $idUser=htmlspecialchars($_SESSION["id"]);
        
        //Open the connection
        db_connect();
        
        $deleteCommentsOfThreadsToDelete=$db->prepare("DELETE FROM comments WHERE id_thread =?");
        
        $deleteCommentsOfThreadsToDelete->bindParam(1, $idThread);
        
        $deleteCommentsOfThreadsToDelete->execute();
        
        //If everything is okay, it will prepare the statement to delete that thread
        $deleteThread=$db->prepare("DELETE FROM threads WHERE id_thread =? AND id_user = ?");
        
        //Put the data in the sql statement
        $deleteThread->bindParam(1, $idThread);
        $deleteThread->bindParam(2, $idUser);
        
        //If the delete goes well it returns you with vraible correct
        if($deleteThread->execute() ){
            header("Location: ../../../public_html/pages/editor/listModifiePage.php?correct=true");
        }
        else{
            header("Location: ../../../public_html/pages/editor/listModifiePage.php?error=true");
        }
        
        
    }
    //if theres no data sended returns to the page with an error
    else {
        header("Location: ../../../public_html/pages/editor/listModifiePage.php?redirected=true");
    }

 
    
 
 

