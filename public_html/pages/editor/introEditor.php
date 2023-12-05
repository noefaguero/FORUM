<!DOCTYPE html>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Forum/private/includes/db_functions.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Forum/private/includes/session_functions.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/user_functions.php';
    
    session_start();
    if (!isset($_SESSION["name"])) {
        header("Location: ../../index.php?redirected=true");
    }

    if (isset($_SESSION["last_activity"])) {
        check_inactivity($_SESSION["last_activity"]);
    }
    
    if (!isset($_COOKIE["theme"])){
        setcookie("theme", "light" , time()+604800 ,"/");
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

                <div class="d-flex flex-column align-items-center">
                    <a class="btn btn-primary m-5 button_size" href="./createThreadPage.php">Añadir un nuevo foro.</a>
                    <a class="btn btn-secondary m-5 button_size" href="./listModifiePage.php">Modificar o eliminar un foro existente.</a>
                </div>

            </main>
            <!-- FOOTER -->
                <?php
                    include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
                ?>
        </div>

    </body>
</html>
