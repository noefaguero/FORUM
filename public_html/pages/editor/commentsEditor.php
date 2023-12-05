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
            include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/aside_editor.php';
        ?>
        <div class="p-0 col-9">
            <!-- HEADER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/header.php';
            ?>
            <!-- MAIN -->
            <main class="main row justify-content-center p-3">
                <div class="accordion col-md-9">
                    <?php
                        try {
                            db_connect();
                            $query1 = "SELECT id_thread, title FROM comments JOIN threads USING(id_thread) WHERE comments.id_user = ?;";
                            $threads = get_array($query1, $_SESSION["id"]);
                            // loop for each category
                            foreach ($threads as $key => $thread) {
                                echo 
                                '<div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed  bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#'.$key.'" aria-expanded="true" aria-controls="collapseOne">'
                                            . $thread .
                                        '</button>
                                    </h2>
                                    <div id="'.$key.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">';
                                // loop for each thread of this category
                                $query2 = "SELECT comment, names FROM comments JOIN users USING(id_user) WHERE comments.id_user=? and id_thread=?";
                                echo comment_group_by($query2, $key, $_SESSION["id"]);
                                echo
                                        '</div>
                                    </div>
                                </div>';   
                            }
                        } catch (Exception $e) {
                            //echo $e->getMessage();
                            header('Location: ../pages/maintenance.php');
                        } finally {
                            db_disconnect();
                        }
                    ?>
                </div>
            </main>
            <!-- FOOTER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>
