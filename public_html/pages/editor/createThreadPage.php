
<!DOCTYPE html>
<?php
    
    require '../../../private/includes/session_functions.php';
    
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
                <main class="dark-blue">
                    
                    <h1>Bienvenido editor:</h1>
                    <h2>Creemos un nuevo hilo:</h2>
                    
                    <?php
                    
                    if(isset($_GET['error']) && $_GET['error']===true ){
                        echo '<div class="alert alert-light col-10 card__account" role="alert">Inserte datos de un hilo para insertar.</div>';
                    }
                    if(isset($_GET['correct']) && $_GET['correct']===true ){
                        echo '<div class="alert alert-light col-10 card__account" role="alert">Hilo insertado correctamente.</div>';
                    }
                    if(isset($_GET['errorex']) && $_GET['errorex']===true ){
                        echo '<div class="alert alert-light col-10 card__account" role="alert">Ha habido un error, vuelve a intentarlo más tarde.</div>';
                    }
                    
                    ?>
                    
                    <form action="../../../private/handlers/threadsHandlers/createThread.php" method="POST">
                        <label>Título del hilo:</label>
                        <input type="text" name="title">
                        
                        <label>Cuerpo:</label>
                        <textarea id="id" name="body" rows="5" cols="20" placeholder="Cuerpo de tu hilo">
                            
                        </textarea>
                        
                        <label>Categoría:</label>
                        <select name="category">
                            <option disabled selected value="escoger">Escoger</option>
                            <option value="cineYSeries">Cine y series</option>
                            <option value="tecnologia">Tecnologia</option>
                            <option value="ciencia">Ciencia</option>
                            <option value="matematica">Matematica</option>
                  
                        </select>

                        <input type="submit" name="submit">
                        
                    </form>
                    
                </main>
            </div>
         
        
        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["name"]);?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>
    </body>
</html>
