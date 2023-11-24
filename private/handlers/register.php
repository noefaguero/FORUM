<?php

include "../private/includes/config_db.php";


//Check if the data has been sent
if( $_SERVER['REQUEST_METHOD']=='POST' ){

    $error = "";

    //Check if the variables are set

    if(isset($_POST['username'])){
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    } else {
        $error.= "username=true&";
    }

    if(isset($_POST['genre'])){
        $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING);
    } else {
        $error.= "genre=true&;";
    }

    if(isset($_POST['email'])){
        $email = strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
    } else {
        $error.= "email=true&;";
    }

    if(isset($_POST['pw1'])){
        $genre = filter_input(INPUT_POST, 'pw1', FILTER_SANITIZE_STRING);
    } else {
        $error.= "pw1=true&;";
    }

    if(isset($_POST['pw2'])){
        $genre = filter_input(INPUT_POST, 'pw2', FILTER_SANITIZE_STRING);
    } else {
        $error.= "pw2=true&";
    }

    if($error === ""){
        if ($pw1 === $pw2){
            header('Location: ../../public_html/index.php');
            insertNewUser($username, $genre, $email, $pw);
        } else {
            $error="repeat";
        }
    } else {
        $error = substr($error, 0, -1);
        header("Location: ../../index.php?$error");
        insertNewUser($username, $genre, $email, $pw1);
    }
}