<?php

$conn_string = "mysql:dbname=FORUM;host=127.0.0.1";
$user = "root";
$key = "";

try {
    // Create the connection to the database
    $bd = new PDO($conn_string, $user, $key);

} catch (Exception $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}