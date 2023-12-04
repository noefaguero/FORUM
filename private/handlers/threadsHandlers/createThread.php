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
    
    $titleCheck = false;
    $bodyCheck = false;
    $categoryCheck = false;
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        if(!isset($_POST['title']) || $_POST['title']=== '' ){
            $titleCheck = true;
        }
        if(!isset($_POST['body']) || $_POST['body']=== '' ){
            $bodyCheck = true;
        }
        if(!isset($_POST['category']) || $_POST['category']=== '' ){
            $categoryCheck = true;
        }
        
        //save variables
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING); 
        $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING); 
        $body = filter_input(INPUT_POST, "body", FILTER_SANITIZE_STRING); 
        $id__User = htmlspecialchars($_SESSION["id"]);
            
        check_select($category);
        
        if($titleCheck==false && $bodyCheck ==false && $categoryCheck==false){
            db_connect();
            
            //Statements to create the thread in the bd
            $createThreadStatement=$db->prepare("INSERT INTO `threads` (`id_thread`, `category`, `title`, `body`, `id_user`) "
                    . "VALUES (NULL, ?, ?, ?, ?);");
            
            
            //Saves the values that we will use in the statements
            $createThreadStatement->bindParam(1, trim($category) );
            $createThreadStatement->bindParam(2, trim($title) );
            $createThreadStatement->bindParam(3, trim($body) );
            $createThreadStatement->bindParam(4, $id__User);
            
            //Execute the statement
            if($createThreadStatement->execute() ){
                header("Location: ../../../public_html/pages/editor/createThreadPage.php?correct=true");
            }
            else{
                header("Location: ../../../public_html/pages/editor/createThreadPage.php?errorex=true");
            }
            
        }
        else{
            header("Location: ../../../public_html/pages/editor/createThreadPage.php?fill=true&title=".$title."&body=". $body. " ");
        }
        
    }
    else{
        header("Location: ../../../public_html/pages/editor/introEditor.php?error=true");
    }
    
