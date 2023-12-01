<!DOCTYPE html>
<?php
    
    
    // check if it has received a POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //get the varaibles 
        $inputUser = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING); 
        $inputKey = filter_input(INPUT_POST, "key", FILTER_SANITIZE_STRING);
        //Variable to check if the execute has given an error
        
        include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/db_functions.php';
        include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/session_functions.php';

        // Send the querys to the database
        try {
            db_connect();
            
            if(user_exist($inputUser, $inputKey)){
                session_start();
                // Save the time when the player has started the session
                $_SESSION["last_activity"] = time();
                
                if(!isset($_COOKIE["session_option"])){
                    set_session_option();
                }
                
                // Redirection
                if($_SESSION["rol"] === "editor"){
                    header("Location:./pages/editor/intro.php");
                }
                else if($_SESSION["rol"] === "subscriber"){
                    header("Location: ./pages/subscriber/index.php"); 
                } else {
                    header('Location: ./pages/maintenance.php');
                }
            } else {
                $error = true;
            }
                
        } catch (Exception $e) {
            //echo $e->getMessage();
            header('Location: ./pages/maintenance.php');
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
        <link rel="stylesheet" href="../public_html/css/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <title>NEXT FORUM</title>
    </head>
        <body class="body">
            <!-- HEADER -->
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
                <main class="main">
                   <div class="my-3 row flex-column align-items-center">
                       <?php
                            if (htmlspecialchars(isset($_GET["redirected"]) ) && htmlspecialchars($_GET["redirected"] == true) ){
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Haga login para continuar' . $_SESSION["id"] . '</div>';
                            }
                            if (isset($error) && $error == true) {
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Revise usuario y contraseña</div>';
                            }
                            if (htmlspecialchars(isset($_GET["timePass"]) ) && htmlspecialchars($_GET["timePass"] == TRUE) ){
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Se ha cerrado la sesión por tiempo de inactividad.</div>';
                            }
                            
                        ?> 
                       <!-- login card -->
                        <article class="col-10 m-5 p-0 card card__account border-0">
                            <!-- card header -->
                            <div class="card-header d-flex justify-content-center">
                                <h2 class="m-0 text-secondary">MI CUENTA</h2>
                            </div>
                            <!-- card footer -->
                            <div class="p-2">
                                <!-- form -->
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="row g-3 p-3">
                                    <!-- email -->
                                    <div class="form-floating">
                                        <input type="text" name="user" class="form-control border-0 bg-light" id="email" value="<?php if (isset($inputUser)) echo $inputUser; ?>" placeholder="usuario">
                                        <label for="floatingEmail" class="ms-2 light-blue">Usuario o email</label>
                                    </div>
                                    <!-- password -->
                                    <div class="form-floating">
                                        <input type="password" name="key" class="form-control border-0 bg-light" id="floatingPassword" placeholder="contraseña">
                                        <label for="floatingPassword" class="ms-2 light-blue">Introduce tu contraseña</label>
                                    </div>
                                    <!-- buttons -->
                                    <div>
                                        <input type="submit" class="btn btn-secondary border-0 dark-blue text-white btn-lg rounded-5 w-100 my-3" value="INICIAR SESIÓN">
                                        <a href="./pages/register.php" class="btn btn-secondary border-0 text-white btn-lg rounded-5 w-100 mb-3">CREAR CUENTA</a>
                                    </div>
                                    <!-- collapse for reset password -->
                                    <div class="mt-0 text-center">
                                        <a class="mx-auto mt-0 mb-2 login__link" data-bs-toggle="collapse" href="#collapseExample">¿Has olvidado tu contraseña?</a>
                                        <div class="collapse mt-3" id="collapseExample">
                                            <!-- card -->
                                            <div class="card dark-blue card-body">
                                                <!-- email -->
                                                <div class="form-floating">
                                                    <input type="email" class="form-control border-0 bg-light" id="floatingEmail2" placeholder="name@example.com">
                                                    <label for="floatingEmail2" class="ms-2 light-blue">Introduce tu correo electrónico</label>
                                                </div>
                                                <!-- submit button -->
                                                <input type="submit" class="btn btn-secondary border-0 text-white btn-lg rounded-5 w-100 my-3" value="ENVIAR">
                                                <p class="light-blue text-white m-0 fw-bold">En breve, recibirás un email con un enlace para restablecer tu contraseña.</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </article>
                   </div>
                </main>
            </div>
            <!-- FOOTER -->
            <footer>
                <!-- social-networks section -->
                <div class="bg-secondary">
                    <div class="container d-flex flex-column mt-3 align-items-center">
                        <div class="d-flex justify-content-center gap-3 my-3">
                            <!-- youtube link -->
                            <a target="_blank" href="" class="btn btn-light rounded-circle p-2">
                                <i class="fa-brands fa-youtube fs-1 light-blue"></i>
                            </a>
                            <!-- twitter link -->
                            <a target="_blank" href="" class="btn btn-light rounded-circle p-2">
                                <i class="fa-brands fa-twitter fs-1 light-blue"></i>
                            </a>
                            <!-- facebook link -->
                            <a target="_blank" href="" class="btn btn-light rounded-circle p-2">
                                <i class="fa-brands fa-facebook fs-1 light-blue"></i>
                            </a>
                            <!-- spotify link -->
                            <a target="_blank" href="" class="btn btn-light rounded-circle p-2">
                                <i class="fa-brands fa-spotify fs-1 light-blue"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- section with logo and link lis -->
                <div class="bg-light">
                    <div class="container d-flex flex-column align-items-center">
                        <!-- links list-->
                        <ul class="nav fs-6 gap-4 justify-content-center py-3">
                            <li class="nav-item"><a class="nav-link light-blue" href="">AVISO LEGAL</a></li>
                            <li class="nav-item"><a class="nav-link light-blue" href="">POLÍTICA DE PRIVACIDAD</a></li>
                            <li class="nav-item"><a class="nav-link light-blue" href="">POLÍTICA DE COOKIES</a></li>
                            <li class="nav-item"><a class="nav-link light-blue" href="">CONDICIONES DE VENTA</a></li>
                            <li class="nav-item"><a class="nav-link light-blue" href="">CONTACTO</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        </body>
</html>
