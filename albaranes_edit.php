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
                    <p class="fs-5 text-muted">Gestiona rápidamente la lista de proveedores y la de albaranes.</p>
                </div>
            </header>

            <main>
                <?php
                    $id=base64_decode($_GET["id"]);
                    include("db.php");
                    $sqlAlbaran = "SELECT `proveedores`.`proveedor`, `numalbaran`, `fecha`, `baseimponible`, `iva`, `total` FROM `albaranes` LEFT JOIN `proveedores` ON `proveedores`.`id`=`albaranes`.`idproveedor`";
                    $sqlAlbaran.=" WHERE `albaranes`.`id`=".$id;
                    
                    $result=$mysqli->query($sqlAlbaran);
                    if($result->num_rows>0){
                        while($fila=$result->fetch_assoc()){
                            $nombre;
                            if($fila["proveedor"]=="")
                                $nombre = "[Proveedor eliminado]";
                            else
                                $nombre = $fila["proveedor"];
                            $numero = $fila["numalbaran"];
                            $fecha = $fila["fecha"];
                            $base = $fila["baseimponible"];
                            $iva = $fila["iva"];
                        }
                    }                    
                ?>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="mb-4">Editar los datos del albarán <?php echo $numero ?></h2>
                        <form id="formProveedorNew" class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $_GET["id"];?>">
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>    
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Nombre</label>
                                <div class="col-sm-4">
                                <select id="nombre" name="nombre" class="form-control">
                                    <?php
                                        include("db.php");
                                        include("funciones.php");
                                        crearLista("proveedores","id","proveedor",conseguirValor('proveedores','id','proveedor',$nombre));
                                    ?>
                                </select>                                   
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="numero" class="col-sm-2 mt-1 control-label">Núm. albarán</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="numero" value="<?php echo $numero ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="fecha" class="col-sm-2 mt-1 control-label">Fecha</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="fecha" value="<?php echo $fecha ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="iva" class="col-sm-2 mt-1 control-label">IVA</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="iva" name="iva" placeholder="IVA" value="<?php echo $iva ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button type="button" id="btnEditAlbaran" class="btn btn-dark">Editar</button>
                                    
                                </div>
                                <div class="col-sm-2">
                                    <a href="albaranes.php" id="btnVolver" class="btn btn-secondary">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                
            </main>

            <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

            <script>             
                $("#btnEditAlbaran").click(function(){
                    let id = $("#id").val();
                    let proveedor = $("#nombre").val()
                    let numero = $("#numero").val()
                    let fecha = $("#fecha").val()
                    let iva = $("#iva").val()

                    var formData = new FormData()
                    formData.append("id",id)
                    formData.append("proveedor",proveedor)
                    formData.append("numero",numero)
                    formData.append("fecha",fecha)
                    formData.append("iva",iva)

                    let error=0;

                    if(error==0){
                        $.ajax({
                            data:formData,
                            url : 'ajax_updateAlbaran.php',                            
                            type : 'POST',
                            contentType:false,
                            cache:false,
                            processData:false,
                            enctype: 'multipart/form-data',
                        }).done(function(data,textStatus,jqXHR) {
                            if(data==1){
                                bootbox.alert({
                                    closeButton: false,
                                    message:"<h3>Albarán actualizado correctamente</h3>",
                                    title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>",
                                    callback: function () {
                                        $(location).attr('href','albaranes.php');
                                    }
                                });                           
                            }else{
                                bootbox.dialog({
                                    closeButton: false,
                                    message:"<h3>Error en la actualización del albarán</h3>",
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