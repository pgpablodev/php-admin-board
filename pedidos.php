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
                    <h1 class="display-4 fw-normal">Pedidos</h1>
                    <a href="pedidos_new.php" class="btn btn-secondary btn-sm btn-icon icon-left">
                        <i class="entypo-plus"></i>
                        Nuevo
                    </a>
                </div>
            </header>

            <main>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Núm. albarán</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include("db.php");
                                $sqlPedido = "SELECT `pedidos`.`id`, `albaranes`.`numalbaran`, `pedidos`.`total` FROM `pedidos` INNER JOIN `albaranes` ON `pedidos`.`idalbaran`=`albaranes`.`id`";                                
                                $result = $mysqli->query($sqlPedido);
                                if($result->num_rows>0){
                                    while($fila=$result->fetch_assoc()){
                                        $id = $fila["id"];
                                        $numAlbaran = $fila["numalbaran"];
                                        $total = $fila["total"];
                                        $sqlLineasPedido = "SELECT `producto`, `precio` FROM `lineaspedido` WHERE `idpedido`=".$id;
                                        $result2 = $mysqli->query($sqlLineasPedido);
                                        if($result2->num_rows>0){
                                            ?>
                                                <tr>
                                                    <td><?php echo $numAlbaran ?></td>
                                                    <td>
                                                        <select id="productos" name="productos" class="form-control">
                                                            <option>Productos del pedido</option>
                                                            <?php
                                                                while($fila2=$result2->fetch_assoc()){
                                                                    $producto = $fila2["producto"];
                                                                    $precio = $fila2["precio"];
                                                                    ?>
                                                                        <option><?php echo $producto." (".$precio." €)"?></option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><?php echo $total ?> €</td>
                                                    <td>
                                                        <a href="pedidos_edit.php?id=<?php echo base64_encode($id); ?>" class="btn btn-secondary btn-sm btn-icon icon-left">
                                                            <i class="entypo-pencil"></i>
                                                            Editar
                                                        </a>
                                                        <button id="btnEliminarPedido<?php echo $id; ?>" class="btn btn-danger btn-sm btn-icon icon-left">
                                                            <i class="entypo-cancel"></i>
                                                            Eliminar
                                                        </button>

                                                        <script>
                                                            $(document).ready(function(){
                                                                $("#btnEliminarAlbaran<?php echo $id; ?>").click(function(){
                                                                    var parent = $(this).parent("td").parent("tr");
                                                                    bootbox.confirm({
                                                                        closeButton: false,
                                                                        message: "<h3>¿Desea eliminar el albarán <?php echo $numAlbaran ?>?</h3>",
                                                                        buttons: {
                                                                            confirm: {
                                                                                label: 'Sí',
                                                                                className: 'btn-danger'
                                                                            },
                                                                            cancel: {
                                                                                label: 'No',
                                                                                className: 'btn-default'
                                                                            }
                                                                        },
                                                                        callback: function(result){
                                                                            if(result){
                                                                                $.ajax({
                                                                                    url: 'ajax_deleteAlbaran.php',
                                                                                    data: {id: <?php echo $id; ?>},
                                                                                    type: 'POST',
                                                                                    dataType: 'html',
                                                                                    success : function(data){
                                                                                        if(data==1){
                                                                                            bootbox.alert({
                                                                                                closeButton: false,
                                                                                                message:"<h3>Albarán eliminado correctamente</h3>",
                                                                                                title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>",
                                                                                                callback: function(){
                                                                                                    parent.fadeOut('slow')
                                                                                                }
                                                                                            });
                                                                                        }else{
                                                                                            bootbox.dialog({
                                                                                                closeButton: false,
                                                                                                message:"<h3>Error en la eliminación del albarán</h3>",
                                                                                                title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>",
                                                                                            });
                                                                                        }
                                                                                    },
                                                                                    error : function(xhr, status) {
                                                                                        alert('Fallo en la petición al servidor');
                                                                                    }
                                                                                });
                                                                            }
                                                                        }
                                                                    });
                                                                })
                                                            })		
                                                        </script>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                }
                            ?>                            
                        </tbody>
                    </table>
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