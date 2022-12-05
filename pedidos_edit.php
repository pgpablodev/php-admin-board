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
            </header>

            <main>
                <?php
                $numLineasDefecto = 0;
                    $id = base64_decode($_GET["id"]);
                    include("db.php");
                    $sqlPedido = "SELECT `pedidos`.`id`, `albaranes`.`id` as `idalbaran`, `pedidos`.`total` FROM `pedidos` INNER JOIN `albaranes` ON `pedidos`.`idalbaran`=`albaranes`.`id`";
                    $sqlPedido.=" WHERE `pedidos`.`id`=".$id;
                    
                    $result=$mysqli->query($sqlPedido);
                    if($result->num_rows>0){
                        while($fila=$result->fetch_assoc()){
                            $id = $fila["id"];
                            $idAlbaran = $fila["idalbaran"];
                            $total = $fila["total"];                            
                        }
                    }                    
                ?>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="mb-4">Editar pedido</h2>
                        <form id="formPedidoEdit" class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value=<?php echo $id ?>>
                        <div class="form-group row mb-3">
                            <div class="col-sm-3"></div>
                            <label for="albaran" class="col-sm-2 mt-1 control-label">Albarán</label>
                            <div class="col-sm-4">
                                <select id="albaran" name="albaran" class="form-control">
                                    <?php
                                        include("db.php");
                                        include("funciones.php");
                                        crearLista("albaranes","id","numalbaran",$idAlbaran);
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div id="lineas">
                            <?php
                                $sqlLineasPedido = "SELECT `id`, `producto`, `precio` FROM `lineaspedido` WHERE `idpedido`=".$id;
                                $result2=$mysqli->query($sqlLineasPedido);
                                if($result2->num_rows>0){
                                    while($fila2=$result2->fetch_assoc()){
                                        $idLinea = $fila2["id"];
                                        $producto = $fila2["producto"];
                                        $precio = $fila2["precio"];
                                        ?>
                                            <input type="hidden" id="idLinea<?php echo $numLineasDefecto?>" value="<?php echo $idLinea ?>">
                                            <div class="form-group row mb-3">
                                                <div class="col-sm-3"></div>    
                                                <label for="producto<?php echo $numLineasDefecto?>" class="col-sm-2 mt-1 control-label">Producto</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="producto<?php echo $numLineasDefecto?>" name="producto<?php echo $numLineasDefecto?>" placeholder="Nombre del producto" value="<?php echo $producto ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row mb-3">
                                                <div class="col-sm-3"></div>
                                                <label for="precio<?php echo $numLineasDefecto?>" class="col-sm-2 mt-1 control-label">Precio</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" class="form-control" id="precio<?php echo $numLineasDefecto?>" name="precio<?php echo $numLineasDefecto?>" placeholder="Precio" value="<?php echo $precio ?>">
                                                </div>
                                            </div>
                                        <?php
                                        $numLineasDefecto++;
                                        $lineasViejas = $numLineasDefecto;
                                    }
                                }
                                $producto = "";
                                $precio = "";
                            ?>                            
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-5"></div>
                            <a id="aniadeProducto" class="col-sm-2 mt-1 control-label text-secondary"><i class="entypo-plus"></i>Producto</a>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-2">
                                <button type="button" id="btnEditPedido" class="btn btn-dark">Editar</button>                                
                            </div>
                            <div class="col-sm-2">
                                <a href="pedidos.php" id="btnVolver" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>                
            </main>

            <script>
                let contadorLineas = <?php echo $numLineasDefecto ?>;
                let lineasViejas = <?php echo $lineasViejas ?>;

                $("#aniadeProducto").click(function(){                  
                    let nuevaLinea =    '<div class="form-group row mb-3">'
                    nuevaLinea +=           '<div class="col-sm-3"></div>'
                    nuevaLinea +=           '<label for="producto'+contadorLineas+'" class="col-sm-2 mt-1 control-label">Producto</label>'
                    nuevaLinea +=           '<div class="col-sm-4">'
                    nuevaLinea +=               '<input type="text" class="form-control" id="producto'+contadorLineas+'" name="producto'+contadorLineas+'" placeholder="Nombre del producto" value="<?php echo $producto ?>">'
                    nuevaLinea +=           '</div>'
                    nuevaLinea +=       '</div>'
                    nuevaLinea +=       '<div class="form-group row mb-3">'
                    nuevaLinea +=           '<div class="col-sm-3"></div>'
                    nuevaLinea +=           '<label for="precio'+contadorLineas+'" class="col-sm-2 mt-1 control-label">Precio</label>'
                    nuevaLinea +=           '<div class="col-sm-4">'
                    nuevaLinea +=               '<input type="number" min="0" class="form-control" id="precio'+contadorLineas+'" name="precio'+contadorLineas+'" placeholder="Precio" value="<?php echo $precio ?>">'
                    nuevaLinea +=           '</div>'
                    nuevaLinea +=       '</div>'
                    contadorLineas = contadorLineas+1
                    $("#lineas").append(nuevaLinea)
                })
            
                $("#btnEditPedido").click(function(){
                    let id = $("#id").val()
                    let albaran = $("#albaran").val()

                    let productos = {}
                    let precios = {}
                    for(i=0;i<contadorLineas;i++){
                        productos['producto'+i]=$("#producto"+i).val()
                        precios['precio'+i]=$("#precio"+i).val()                        
                    }
                    let idsLinea = {}
                    for(i=0;i<lineasViejas;i++){
                        idsLinea['idLinea'+i] = $("#idLinea"+i).val()
                    }

                    var formData = new FormData()

                    formData.append("id",id)
                    formData.append("albaran",albaran)
                    for(i=0;i<lineasViejas;i++){
                        formData.append("idLinea"+i,idsLinea['idLinea'+i])
                    }
                    for(i=0;i<contadorLineas;i++){
                        formData.append("producto"+i,productos['producto'+i])
                        formData.append("precio"+i,precios['precio'+i])
                    }
                    formData.append("contadorLineas",contadorLineas)
                    formData.append("lineasViejas",lineasViejas)
                    let error=0;

                    if(error==0){
                        $.ajax({
                            data:formData,
                            url : 'ajax_updatePedido.php',                            
                            type : 'POST',
                            contentType:false,
                            cache:false,
                            processData:false,
                            enctype: 'multipart/form-data',
                        }).done(function(data,textStatus,jqXHR) {
                            if(data==1){
                                bootbox.alert({
                                    closeButton: false,
                                    message:"<h3>Pedido actualizado correctamente</h3>",
                                    title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>",
                                    callback: function () {
                                        $(location).attr('href','pedidos.php');
                                    }
                                });                          
                            }else{
                                bootbox.dialog({
                                    closeButton: false,
                                    message:"<h3>Error en la actualización del pedido</h3>",
                                    title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>"
                                });
                            }
                        }).fail(function(jqXHR,textStatus,errorThrown) {
                            alert('Fallo en la petición al servidor');
                        });
                    }
                });
            </script>

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