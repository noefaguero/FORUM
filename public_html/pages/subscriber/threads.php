<!DOCTYPE html>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/db_functions.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/session_functions.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/user_functions.php';
    
    session_start();
    if(!isset($_SESSION["name"])){
        header("Location: ../../index.php?redirected=true");
    }
    
    if (isset($_SESSION["last_activity"])){
        check_inactivity($_SESSION["last_activity"]);
    }
    
    if($_SERVER['REQUEST_METHOD']=='GET'){ 
        $thr = filter_input(INPUT_GET, "thread", FILTER_VALIDATE_INT);
        if(isset($_GET["id_remove"])){
            $id_remove = filter_input(INPUT_GET, "id_remove", FILTER_VALIDATE_INT);
        } 
        
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST'){ 
        
        $newcomment = filter_input(INPUT_POST, "newcomment", FILTER_SANITIZE_STRING);
        $thr = filter_input(INPUT_POST, "id_thread", FILTER_VALIDATE_INT);

        try {
            db_connect();
            insert_comment($newcomment, $thr, $_SESSION["id"]);

        } catch (Exception $e) {
            //echo $e->getMessage();
            header('Location: ../pages/maintenance.php');
        } finally {
            db_disconnect();
        }
    }
    
?>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/styles.css">
        <link rel="stylesheet" href="<?php echo check_theme($_COOKIE["theme"]); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <title>NEXT FORUM</title>
    </head> 
    <!-- container -->
    <body class="container-fluid p-0 m-0 row position-relative">
        <!-- ASIDE -->
        <?php
            include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/aside_subscriber.php';
        ?>
        <div class="p-0 col-9">
            <!-- HEADER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/header.php';
            ?>
            <!-- MAIN -->
            <main class="main row justify-content-center p-3">
                <div class="col-md-9">
                    
                    <?php
                        try {
                            db_connect();
                            echo '<div type="button" class="card body text-white text-center w-100 d-flex flex-column justify-content-space-around p-3">'.show_thread($thr).'</div>';
                            $query1= "SELECT comment, names, id_comment FROM comments JOIN users USING(id_user) WHERE  id_thread=?";
                            echo comment_group_by($query1, $thr);
                           
                        } catch (Exception $e) {
                            //echo $e->getMessage();
                            header('Location: ../pages/maintenance.php');
                        } finally {
                            db_disconnect();
                        }
                    ?>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="m-3 row">
                        <textarea name="newcomment" rows="5" cols="10" placeholder="Comenta en este hilo"></textarea>
                        <input type="hidden" name="id_thread" value="<?php echo $thr; ?>">
                        <input type="submit" class="btn btn-secondary mt-3" value="ENVIAR">
                    </form>
                    

                </div>
            </main>
            <!-- FOOTER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
            ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>