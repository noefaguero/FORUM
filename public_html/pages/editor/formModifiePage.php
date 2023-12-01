


<!DOCTYPE html>
<?php
    
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/db_functions.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/session_functions.php';
    
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
        <meta charset="UTF-8">
        <title>Modo edición-NextForum</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="../public_html/css/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        
    </head>
    <body>

        <header>
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid d-flex justify-content-evenly">
                    <p class="m-0 text-secondary fs-4 mt-5">Es el momento de opinar</p>
                    <div class="bg-black border-0 rounded-4 p-3 m-3">
                        <span class="logo mx-auto my-3 fs-1 fw-2 text-white">nextFORUM</span>
                    </div>
                    <p class="m-0 text-secondary fs-4 mt-5">Comparte tu experiencia</p>
                </div>
            </nav>
        </header>
         <!-- container -->
            <div class="container">
                <!-- MAIN -->
                <main class="main dark-blue">
                    
                    <h1>Bienvenido editor:</h1>
                    <h2>Que hilo quieres modificar:</h2>
                    
                    
                </main>
            </div>
         
        
        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["user"]);?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>
    </body>
</html>
