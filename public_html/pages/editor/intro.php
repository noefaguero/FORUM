<!DOCTYPE html>
<?php
    
    require '../../../private/includes/sessionFunctions.php';
    
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: ../../index.php?redirected=true");
    }
    
    
    checkInactivityTimePassed($_SESSION["lastAcces"]);
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>PRINCIPAL</title>
    </head>
    <body>
        <h1> Bienvenido <?php echo htmlspecialchars($_SESSION["user"]);?> </h1>
        <br>
        <a href="../../../private/handlers/logout.php">Salir</a>
    </body>
</html>
