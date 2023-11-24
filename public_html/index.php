<!DOCTYPE html>
<?php
    $errorExecute=FALSE;
    // check if it has received a POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //get the varaibles 
        $inputUser = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING); 
        $inputKey = filter_input(INPUT_POST, "key", FILTER_SANITIZE_STRING);
        //Variable to check if the execute has given an error
        
        include "../private/includes/config_db.php";
        include "../private/includes/user_functions.php";

        // Send a query to the database
        try {
            
            //Prepared statement to select all users from the BD
            $sql=$bd->prepare("SELECT names, email, pw, rol FROM users");
            
            //Execute the query
            if($sql->execute() ){
                
                // If the identification is correct, the session starts
                if (check_user($sql, $inputUser, $inputKey)) {
                    //Start the session 
                    session_start();
                    $_SESSION["user"] = $inputUser;
//                    $_SESSION["rol"]= $sql[3];

                    //Relocate the user to the intro page
                    header("Location: ./pages/editor/intro.php");
                // If there is an error in the user
                } else {
                    $error = TRUE;
                    $user = $inputUser;
                }

                // Close the connection
                $bd = null;
                
            }
            else{
               $errorExecute = TRUE;
            }
            

        } catch (Exception $e) {
            echo "Error en la consulta a la base de datos: " . $e->getMessage();
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
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Haga login para continuar</div>';
                            }
                            if(isset($errorExecute)&&$errorExecute === TRUE){
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Ha ocurrido un error, vuelve a intentarlo.</div>';
                            }
                            if (isset($error) && $error == true) {
                                echo '<div class="alert alert-light col-10 card__account" role="alert">Revise usuario y contraseña</div>';
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
                                        <input type="text" name="user" class="form-control border-0 bg-light" id="email" value="<?php if (isset($user)){ echo $user;} ?>" placeholder="usuario">
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
                                        <button type="button" class="btn btn-secondary border-0 text-white btn-lg rounded-5 w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modal">CREAR CUENTA</button>
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
            <!-- sign up modal -->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- modal header -->
                        <div class="modal-header">
                            <h1 class="modal-title fs-2 options__title m-0" id="exampleModalLabel">REGISTRATE</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- modal body -->
                        <div class="modal-body">
                            
                            <!--Form to register an user-->
                            <form action="../private/handlers/register.php" method="post" class="row g-3 p-3">
                                <!-- name -->
                                <div class="form-floating col-xl-4">
                                    <input type="text" class="form-control border-0 bg-light" id="floatingInput1" placeholder="first name" name="name">
                                    <label for="floatingInput1" class="ms-2 light-blue">Nombre</label>
                                </div>
                                <!-- second name -->
                                <div class="form-floating col-xl-8">
                                    <input type="text" class="form-control border-0 bg-light" id="floatingInput2" placeholder="second name" name="secondName">
                                    <label for="floatingInput2" class="ms-2 light-blue">Apellidos</label>
                                </div>
                                <!-- gender -->
                                <div class="form-floating ">
                                    <select class="form-select form-control border-0 bg-light" id="floatingSelect" aria-label="Floating label select example" name="gender">
                                        <option value="" disabled selected>Escoge</option>
                                        <option value="M">Hombre</option>
                                        <option value="F">Mujer</option>
                                    </select>
                                    <label for="floatingSelect" class="ms-2 light-blue">Género</label>
                                </div>
                                <!-- email -->
                                <div class="form-floating">
                                    <input type="email" class="form-control border-0 bg-light" id="floatingEmail" placeholder="name@example.com" name="email">
                                    <label for="floatingEmail" class="ms-2 light-blue">Correo electrónico</label>
                                </div>
                                <!-- password -->
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0 bg-light" id="floatingPassword1" placeholder="Password" name="password">
                                    <label for="floatingPassword1" class="ms-2 light-blue">Introduce tu contraseña</label>
                                </div>
                                <!-- repeat password -->
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0 bg-light" id="floatingPassword2" placeholder="Password2" name="repeatPassword">
                                    <label for="floatingPassword2" class="ms-2 light-blue">Repite tu contraseña</label>
                                </div>
                                <!-- checking -->
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input ps-2" type="checkbox" value="" id="invalidCheck2" required>
                                        <label class="form-check-label" for="invalidCheck2">
                                            Acepto la política de privacidad
                                        </label>
                                    </div>
                                </div>
                                <!-- submit button -->
                                <div>
                                    <input type="submit" class="btn btn-secondary border-0 dark-blue text-white btn-lg rounded-5 w-100 my-3" value="ENVIAR">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        </body>
</html>