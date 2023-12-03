<?php
    
    try {
        db_connect();

        $comments = records_count("comments WHERE id_user=" . $_SESSION["id"]);
        $threads = records_count("threads");
        $editors = records_count("users WHERE rol='editor'");
        
    } catch (Exception $e) {
        //echo $e->getMessage();
        header('Location: ../pages/maintenance.php');
    } finally {
        db_disconnect();
    }
    
?>

<aside class="d-flex vh-100 col-3 p-0 position-sticky start-0 top-0 flex-column justify-content-between body">
    <div>
        <!-- user image and name -->
        <div class="d-flex flex-column align-items-center justify-content-center p-4 me-3">
            <img class="img-fluid w-50" src="<?php echo '../../assets/images/avatar.png';?>" alt="#">
            <p class="text-white">
                <?php echo htmlspecialchars($_SESSION["name"]); ?>
            </p>
        </div>
        <!-- rol -->
        <div class="text-white d-flex justify-content-center bg-secondary p-3">
            <p class="m-0"><?php echo htmlspecialchars(strtoupper($_SESSION["rol"])); ?></p>
        </div>
        <!-- vertical navigation bar -->
        <nav class="navbar">
            <div class="container-fluid p-0">        
                <!-- links list -->
                <ul class="navbar-nav w-75 p-2 mx-auto">
                    <!-- threads -->
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between" href="./index.php">
                            <p>TEMAS</p>
                            <p><?php echo $threads; ?></p>
                        </a>
                    </li>
                    <!-- comments -->
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between" href="./comments.php">
                            <p>MIS COMENTARIOS</p>
                            <p><?php echo $comments; ?></p>
                        </a>
                    </li>
                    
                    <!-- editors -->
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between" href="./editors.php">
                            <p>EDITORES</p>
                            <p><?php echo $editors; ?></p>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- vertical navigation bar -->
    <nav class="navbar border-top border-2 border-white">
        <ul class="navbar-nav w-75 p-2 mx-auto">
            <!-- configuration link -->
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between" href="./settings.php">Configuración</a>
            </li>
            <!-- log out link -->
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between" href="../../../private/handlers/logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </nav>
</aside>
