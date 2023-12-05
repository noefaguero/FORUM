
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
                if (isset($_GET["error"]) && $_GET["error"] === true) {
                    echo '<div class="alert alert-light col-10 card__account" role="alert">Escoge un hilo que cambiar.</div>';
                }
                
                if (isset($_GET["correctUpdate"]) && $_GET["correctUpdate"] === true) {
                    echo '<div class="alert alert-light col-10 card__account" role="alert">Cambio realizado correctamente.</div>';
                }
                
                global $db;
                db_connect();
                //Prepare the statement to select all the threads that the editor has created
                $sqlEditorThreads = $db->prepare("SELECT category, title, body, id_thread FROM threads WHERE id_user = ?");

                //Execute the query
                if ($sqlEditorThreads->execute([$_SESSION["id"]])) {
                    //Start the table
                    echo '<ul class="list">';
                    $threadCont = 1;

                    //Header of the table that will show the threads
                    echo '<div class="list__thread">';
                    echo '<div class="list__data stronger">NºHilo</div>';
                    echo '<div class="list__data stronger">Categoría</div>';
                    echo '<div class="list__data stronger">Título</div>';
                    echo '<div class="list__data stronger">Cuerpo</div>';
                    echo '<div class="list__data stronger">Modificar</div>';
                    echo '<div class="list__data stronger">Comentarios</div>';
                    echo '<div class="list__data stronger">Eliminar</div>';
                    echo '</div>';

                    //Part with the lists of threads
                    foreach ($sqlEditorThreads as $thread) {

                        //Link to the form to edit this thread
                        echo '<div class="list__thread">';

                        echo '<div class="list__data">' . $threadCont . '</div>'; //Show the cell that will write the number of the thread

                        echo '<div class="list__data">' . $thread["category"] . '</div>';

                        echo '<div class="list__data">' . $thread["title"] . '</div>';

                        echo '<div class="list__data">' . $thread["body"] . '</div>';

                        echo '<div class="list__data"> <a class="btn btn-secondary list__link" href="./formModifiePage.php?&title=' . $thread["title"] . '&body=' . $thread["body"] . '&beforIdThread=' . $thread["id_thread"] . '">Modificar.</a> </div>';

                        echo '<div class="list__data"> <a class="btn btn-secondary list__link" href="">Comentarios.</a> </div>';

                        echo '<div class="list__data">'
                        . '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="' . "#thr" . $thread["id_thread"] . '">Eliminar.</button>'
                                
                        . '<div class="modal fade" id="' . "thr" . $thread["id_thread"] . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Seguro que quieres eliminar el hilo?</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Vas a eliminar el hilo con título "' . $thread["title"] . '".</p>
                                                <p>¿Seguro?</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                              <a href="../../../private/handlers/threadsHandlers/eliminateThread.php?idThread=' . $thread["id_thread"] . '" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>'
                        . '</div>';

                        echo '</div>';
                        $threadCont++;
                    }
                    //End of the table
                    echo '</ul>';
                } else {
                    header("Location: ../editor/listModifiePage.php?error=TRUE");
                }

                db_disconnect();
                ?>

                <!-- Modal -->



            </main>
        </div>

        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["name"]); ?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
