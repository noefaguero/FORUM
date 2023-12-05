
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
                    
                <form class="d-flex flex-column w-50" action="../../../private/handlers/threadsHandlers/createThread.php" method="POST">
                    <?php
                    
                    if(isset($_GET['error']) && $_GET['error']===true ){
                        echo '<div class="alert alert-danger card__account" role="alert">Inserte datos de un hilo para insertar.</div>';
                    }
                    if(isset($_GET['correct']) && $_GET['correct']==true ){
                        echo '<div class="alert alert-success col-10 card__account" role="alert">Hilo insertado correctamente.</div>';
                    }
                    if(isset($_GET['errorex']) && $_GET['errorex']==true ){
                        echo '<div class="alert alert-danger col-10 card__account" role="alert">Ha habido un error, vuelve a intentarlo más tarde.</div>';
                    }
                    if(isset($_GET['fill']) && $_GET['fill']==true ){
                        echo '<div class="alert alert-danger card__account" role="alert">Tiene que rellenar todos los campos.</div>';
                    }
                    ?>    
                    
                    <label>Título del hilo:</label>
                    <input type="text" name="title" placeholder="Titulo" value="<?php if(isset($_GET['title']) ){echo $_GET['title'];}?>">

                    <label>Cuerpo:</label>
                    <textarea id="id" name="body" rows="5" cols="20" placeholder="Cuerpo de tu hilo"><?php if(isset($_GET['body'])){echo $_GET['body'];}?></textarea>

                    <label>Categoría:</label>
                    <select name="category">
                        <option disabled selected value="escoger">Escoger</option>
                        <option value="cineYSeries">Cine y series</option>
                        <option value="tecnologia">Tecnologia</option>
                        <option value="ciencia">Ciencia</option>
                        <option value="matematica">Matematica</option>

                    </select>

                    <input class="mt-3 btn btn-primary" type="submit" name="submit">
                        
                </form>
                    
                </main>
            <!-- FOOTER -->
                <?php
                    include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
                ?>
            </div>
         
        
        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["name"]);?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>
    </body>
</html>
