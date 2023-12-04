<?php
include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/db_functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = filter_input(INPUT_POST, "id_remove", FILTER_VALIDATE_INT);
        
        try {
            db_connect();
            delete_comment($id);

        } catch (Exception $e) {
            //echo $e->getMessage();
            header('Location: ' . $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/pages/maintenance');
        } finally {
            db_disconnect();
        }
        
        header("Location: ". $_SERVER['HTTP_REFERER']);

}


