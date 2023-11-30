<?php

    require $_SERVER['DOCUMENT_ROOT'].'/ForumCorect/private/includes/config_db.php';
    include $_SERVER['DOCUMENT_ROOT'].'/ForumCorect/private/includes/sessionFunctions.php';
    
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../../index.php?redirected=true");
    }
    checkInactivityTimePassed($_SESSION["lastAcces"]);
    
    
    //If there havent been any value sended it will return
    if($_SERVER["REQUEST_METHOD"]==='GET'){
        
        //if no data in get returns
        if(!isset($_GET["idThread"]) ){
            header("Location: ../../../public_html/pages/editor/listModifiePage.php?redirected=true");   
        }
        
        //If everything is okay, it will prepare the statement to delete that thread
        $deleteThread=$bd->prepare("DELETE FROM threads WHERE id_thread =? AND id_user = ?");   
        
        $idThread=htmlspecialchars($_GET["idThread"]);
        $idUser=htmlspecialchars($_SESSION["id"]);
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

 
    
 
 

