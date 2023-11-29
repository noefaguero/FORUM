<!DOCTYPE html>
<?php

include $_SERVER['DOCUMENT_ROOT'].'/Forum/private/includes/user_functions.php';

$errors = [];

//Check if the data has been sent
if( $_SERVER['REQUEST_METHOD']=='POST' ){
    
    //get the variables 
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $rol = filter_input(INPUT_POST, "rol", FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
    $pw1_row = filter_input(INPUT_POST, "pw1", FILTER_SANITIZE_STRING);
    $pw1 = password_hash($pw1_row, PASSWORD_DEFAULT);
    $pw2_row = filter_input(INPUT_POST, "pw2", FILTER_SANITIZE_STRING);
    
    // detect empty fields
    $errors = empty_field();
  
    if(count($errors) == 0){
        if ($pw1_row == $pw2_row){
            insert_user($username, $rol, $gender, $email, $pw1);
            header('Location: ../index.php');
            
        } else {
            array_push($errors, "pw1", "pw2");
            $error_pw = true;
        }
    } else {
        $error_empty = true;
    }
}

?>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/styles.css">
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
                        if (isset($error_empty) && $error_empty == true) {
                            echo '<div class="alert alert-light col-10 card__account" role="alert">Los siguientes campos son obligatorios</div>';
                        }
                        if (isset($error_pw) && $error_pw == true) {
                            echo '<div class="alert alert-light col-10 card__account" role="alert">La contraseña no coincide</div>';
                        }
                    ?> 
                    <!-- sign up card -->
                    <article class="col-10 m-5 p-0 card card__account border-0">
                        <!-- card header -->
                        <div class="card-header d-flex justify-content-center">
                            <h2 class="m-0 text-secondary">REGÍSTRATE</h2>
                        </div>
                        <!-- card footer -->
                        <div class="p-2">
                            <!--Form to register an user-->
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="row g-3 p-3">
                                <!-- name -->
                                <div class="form-floating">
                                    <input type="text" value="<?php if(isset($username)) echo $username; ?>" class="<?php echo show_error("username", $errors); ?>" id="floatingName" placeholder="name" name="username">
                                    <label for="floatingName" class="ms-2 light-blue">Nombre</label>
                                </div>
                                <!-- rol -->
                                <div class="form-floating col-xl-6">
                                    <select name="rol" class="form-select form-control border-0 bg-light" id="floatingSelect1">
                                        <option value="editor">Editor</option>
                                        <option value="subscriber">Suscriptor</option>
                                    </select>
                                    <label for="floatingSelect1" class="ms-2 light-blue">Tipo de cuenta</label>
                                </div>
                                <!-- gender -->
                                <div class="form-floating col-xl-6">
                                    <select class="form-select form-control border-0 bg-light" id="floatingSelect2" name="gender">
                                        <option value="M">Hombre</option>
                                        <option value="F">Mujer</option>
                                    </select>
                                    <label for="floatingSelect2" class="ms-2 light-blue">Género</label>
                                </div>
                                <!-- email -->
                                <div class="form-floating">
                                    <input type="email" value="<?php if(isset($email)) echo $email; ?>" class="<?php echo show_error("email", $errors); ?>" id="floatingEmail" placeholder="email" name="email" >
                                    <label for="floatingEmail" class="ms-2 light-blue">Correo electrónico</label>
                                </div>
                                <!-- password -->
                                <div class="form-floating">
                                    <input type="password" class="<?php echo show_error("pw1", $errors); ?>" id="floatingPassword1" placeholder="password" name="pw1">
                                    <label for="floatingPassword1" class="ms-2 light-blue">Nueva contraseña</label>
                                </div>
                                <!-- repeat password -->
                                <div class="form-floating">
                                    <input type="password" class="<?php echo show_error("pw2", $errors); ?>" id="floatingPassword2" placeholder="password" name="pw2">
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
                    </article>
                </div>
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>