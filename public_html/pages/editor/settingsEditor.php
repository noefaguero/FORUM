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
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST["extended"])){
            set_session_option(EXTENDED);
            $switch ='checked';
        } else {
            set_session_option(SHORT);
             $switch ='';
        }
        if (isset($_POST["theme"])){
            $color = htmlspecialchars($_POST["theme"]);
            setcookie("theme", $color , time()+604800 ,"/");
        }
    } else {
       if ($_COOKIE["session_option"] == EXTENDED ) {
            $switch ='checked';
        } else {
            $switch ='';
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
            include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/aside_editor.php';
        ?>
        <div class="p-0 col-9">
            <!-- HEADER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/header.php';
            ?>
            <!-- MAIN -->
                <main class="main row justify-content-center">
                    <!-- login card -->
                    <article class="col-5 m-5 p-0 card border-0">
                        <!-- card header -->
                        <div class="card-header d-flex justify-content-center">
                            <h2 class="fs-3">PREFERENCIAS</h2>
                        </div>
                        <!-- card footer -->
                        <div class="p-2">
                            <!-- form -->
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="row g-3 p-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="extended" type="checkbox"  role="switch" id="extended" <?php echo $switch; ?> >
                                    <label class="form-check-label" for="extended">Sesión ampliada</label>
                                </div>
                                <div class="d-flex gap-4 justify-content-center align-items-center mb-5">
                                    <label class="form-check-label" for="theme">Tema</label>
                                    <select class="form-select" id="theme" name="theme" aria-label="Default select example">
                                        <option value="light">light</option>
                                        <option value="dark">dark</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-secondary border-0 dark-blue text-white btn-lg rounded-5 w-100 my-3" value="GUARDAR">
                            </form>
                        </div>
                    </article>
                </main>
                <!-- FOOTER -->
                <?php
                    include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
                ?>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        </body>
</html>