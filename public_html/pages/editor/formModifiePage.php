
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

                <?php
                    
                    $titleChecker = false;
                    $bodyChecker = false;

                    if (isset($_GET['beforTitle'])) {
                        $beforeTitle = filter_input(INPUT_GET, "beforTitle", FILTER_SANITIZE_STRING);
                    } else {
                        $beforeTitle = "";
                    }

                    if (isset($_GET['beforBody'])) {
                        $beforeBody = filter_input(INPUT_GET, "beforBody", FILTER_SANITIZE_STRING);
                    } else {
                        $beforeBody = "";
                    }

                    if (isset($_GET['beforIdThread'])) {
                        $idThread = filter_input(INPUT_GET, "beforIdThread", FILTER_SANITIZE_STRING);
                    } else {
                        $beforeBody = "";
                    }

                    if (isEmpty($beforeTitle)) {
                        $titleChecker = true;
                    }
                    if (isEmpty($beforeBody)) {
                        $bodyChecker = true;
                    }
                ?>

                <form class="d-flex flex-column w-50" action="../../../private/handlers/threadsHandlers/modifieThread.php" method="POST">
                    
                    <?php 
                    if (isset($_GET["fillErr"]) && $_GET["fillErr"] == true) {
                        echo '<div class="alert alert-danger col-10 card__account" role="alert">Rellene todos los datos.</div>';
                        $fillErr = true;
                    }
                    if (isset($_GET["correctUpdate"]) && $_GET["correctUpdate"] == true) {
                        echo '<div class="alert alert-success col-10 card__account mt-5" role="alert">Hilo actualizado correctamente.</div>';
                    }
                    ?>
                    
                    <label>Título del hilo:</label>
                    <input type="text" placeholder="Titulo del hilo." name="title" value="<?php if (isset($_GET["title"])) {echo $_GET["title"];} ?>">


                    <label>Cuerpo:</label>
                    <textarea id="id" name="body" rows="5" cols="20" placeholder="Cuerpo del hilo."><?php if (isset($_GET["body"])) {echo $_GET["body"];} ?></textarea>

                    <label>Categoría:</label>
                    <select name="category">
                        <option disabled selected value="escoger">Escoger</option>
                        <option value="Cine y series">Cine y series</option>
                        <option value="Tecnología">Tecnologia</option>
                        <option value="Ciencia">Ciencia</option>
                        <option value="Matematica">Matematica</option>

                    </select>

                    <input type="hidden" name="idThreadToUpdate" value="<?= $idThread ?>">

                    <input class="mt-3 btn btn-primary"  type="submit" name="submit">

                </form>

            </main>
            <!-- FOOTER -->
            <?php
                include $_SERVER['DOCUMENT_ROOT'].'/Forum/public_html/templates/footer.php';
            ?>
        </div>


        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["name"]); ?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>
    </body>
</html>
