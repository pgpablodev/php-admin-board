<?php
    session_start();
    if(isset($_SESSION["validado"])){
        if($_SESSION["validado"]!="1")
        header("location:login.php");
    }else{
        header("location:login.php");
    }
?>

<!doctype html>
<html lang="en">
    <?php include("head.php") ?>    
    <body>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check" viewBox="0 0 16 16">
                <title>Check</title>
                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
            </symbol>
        </svg>

        <div class="container py-3">
            <header>
                <?php include("top.php") ?>

                <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4 fw-normal">Panel de control</h1>
                    <p class="fs-5 text-muted">Gestiona rápidamente las listas de proveedores, pedidos y albaranes.</p>
                </div>
            </header>

            <main>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h2><a style="text-decoration: none; color: inherit;" href="proveedores.php">Proveedores</a></h2>
                        <a href="proveedores_new.php" class="btn btn-secondary btn-sm btn-icon icon-left">
                            <i class="entypo-plus"></i>
                            Nuevo
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <h2><a style="text-decoration: none; color: inherit;" href="pedidos.php">Pedidos</a></h2>
                        <a href="pedidos_new.php" class="btn btn-secondary btn-sm btn-icon icon-left">
                            <i class="entypo-plus"></i>
                            Nuevo
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <h2><a style="text-decoration: none; color: inherit;" href="albaranes.php">Albaranes</a></h2>
                        <a href="albaranes_new.php" class="btn btn-secondary btn-sm btn-icon icon-left">
                            <i class="entypo-plus"></i>
                            Nuevo
                        </a>
                    </div>
                </div>                
            </main>

            <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <img class="mb-2" src="bootstrap-logo.svg" alt="" width="24" height="19">
                        <small class="d-block mb-3 text-muted">&copy; 2017–2022</small>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Cool stuff</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Random feature</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Team feature</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Stuff for developers</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Another one</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Last time</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Resources</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Resource</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Resource name</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Another resource</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Final resource</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>About</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Team</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Locations</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Privacy</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>