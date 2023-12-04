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
    
    $afterCategoryChecker = false;
    $afterTitleChecker = false;
    $afterBodyChecker = false;
    
    $idChecker = false;
    
    //Check if data sended to the page by post
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: ../../../public_html/pages/editor/listModifiePage.php");
    }
    
    //Check if all the variables has values
    if(!isset($_POST['title']) ){
        $afterTitleChecker = true;
    }
    if(!isset($_POST['body']) ){
        $afterBodyChecker = true;
    }
    if(!isset($_POST['category']) ){
        $afterCategoryChecker = true;
    }
    if(!isset($_POST['idThreadToUpdate']) ){
        $idChecker = true;
    }
    
    //Filter the values
    $title = trim( filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING)); 
    $category = trim(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING)); 
    $body = trim(filter_input(INPUT_POST, "body", FILTER_SANITIZE_STRING)); 
    $id__User = trim(htmlspecialchars($_SESSION["id"]));
    $id_thread = trim(filter_input(INPUT_POST, "idThreadToUpdate", FILTER_SANITIZE_STRING));
    
    //Checj if the select is empty
    if(check_select($category) ){
        $afterCategoryChecker=true;
    } 
    
    //Check if any data is empty
    if($afterCategoryChecker==true || isEmpty($title) || isEmpty($category) || isEmpty($body) || isEmpty($id__User) || isEmpty($id_thread) ){
        header("Location: ../../../public_html/pages/editor/formModifiePage.php?fillErr=true&title=".$title."&body=".$body."");
    }
    
    
    if($afterTitleChecker==false && $afterBodyChecker ==false && $afterCategoryChecker==false && $idChecker == false){
        db_connect();
        global $db;
        //Statements to create the thread in the bd
        $updateThreadStatement = $db->prepare("UPDATE `threads` SET `category` = :categoria, `title` = :titulo, `body` = :cuerpo WHERE `threads`.`id_thread` = :idHilo");
        
        try{
            
            if($updateThreadStatement->execute(array(":categoria" => $category, ":titulo"=> $title, ":cuerpo"=>$body, ":idHilo"=>$id_thread) ) ){
                header("Location: ../../../public_html/pages/editor/listModifiePage.php?correctUpdate=true");
            }
            else{
                header("Location: ../../../public_html/pages/editor/listModifiePage.php?errorUpdate=true");
            }
        }
        catch (Exception $ex) {
            echo $ex->getMessage();
            echo $ex->getFile();
            echo $ex->getTrace();
//            header("Location: ../../../public_html/pages/editor/listModifiePage.php?err=true");
        }
        
    }
    

