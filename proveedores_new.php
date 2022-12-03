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
                    $nombre="";
                    $cif="";
                    $calle="";
                    $cp="";
                    $ciudad="";
                    $tlf="";
                    $email="";
                ?>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="mb-4">Añadir nuevo proveedor</h2>
                        <form id="formProveedorNew" class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>    
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Nombre</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">CIF</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="cif" name="cif" placeholder="Cif" value="<?php echo $cif ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Calle</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" value="<?php echo $calle ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Cód. postal</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="cp" name="cp" placeholder="Código postal" value="<?php echo $cp ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Ciudad</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?php echo $ciudad ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Teléfono</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="tlf"  name="tlf" placeholder="Teléfono" value="<?php echo $tlf ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3"></div>
                                <label for="nombre" class="col-sm-2 mt-1 control-label">Correo</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="email"  name="email" placeholder="Correo electrónico" value="<?php echo $email ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button type="button" id="btnNuevoProveedor" class="btn btn-dark">Crear</button>
                                    
                                </div>
                                <div class="col-sm-2">
                                    <a href="proveedores.php" id="btnVolver" class="btn btn-secondary">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                
            </main>

            <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

            <script>             
                $("#btnNuevoProveedor").click(function(){
                    let nombre = $("#nombre").val()
                    let cif = $("#cif").val()
                    let calle = $("#calle").val()
                    let cp = $("#cp").val()
                    let ciudad = $("#ciudad").val()
                    let tlf = $("#tlf").val()
                    let email = $("#email").val()

                    var formData = new FormData()
                    formData.append("nombre",nombre)
                    formData.append("cif",cif)
                    formData.append("calle",calle)
                    formData.append("cp",cp)
                    formData.append("ciudad",ciudad)
                    formData.append("tlf",tlf)
                    formData.append("email",email)

                    let error=0;

                    if(error==0){
                        $.ajax({
                            data:formData,
                            url : 'ajax_insertProveedor.php',                            
                            type : 'POST',
                            contentType:false,
                            cache:false,
                            processData:false,
                            enctype: 'multipart/form-data',
                        }).done(function(data,textStatus,jqXHR) {
                            if(data==1){
                                bootbox.alert({
                                    closeButton: false,
                                    message:"<h3>Proveedor insertado correctamente</h3>",
                                    title:"<i class='fa-solid fa-circle-info fa-3x text-info'></i><span class='text-info'>&nbsp;INFORMACIÓN</span>",
                                    callback: function () {
                                        $(location).attr('href','proveedores.php');
                                    }
                                });                       
                            }else{
                                bootbox.dialog({
                                    closeButton: false,
                                    message:"<h3>Error en la inserción del proveedor</h3>",
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