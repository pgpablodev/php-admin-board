<?php
    include("db.php");

    $id = base64_decode($_POST["id"]);

    $nombre=$_POST["nombre"];
    $cif=$_POST["cif"];
    $calle=$_POST["calle"];
    $cp=$_POST["cp"];
    $ciudad=$_POST["ciudad"];
    $tlf=$_POST["tlf"];
    $email=$_POST["email"];

    $sqlUpdateProveedor = "UPDATE `proveedores` SET ";
    $sqlUpdateProveedor .= "`proveedor`='".$nombre."', ";
    $sqlUpdateProveedor .= "`cif`='".$cif."', ";
    $sqlUpdateProveedor .= "`calle`='".$calle."', ";
    $sqlUpdateProveedor .= "`cp`='".$cp."', ";
    $sqlUpdateProveedor .= "`ciudad`='".$ciudad."', ";
    $sqlUpdateProveedor .= "`telefono`='".$tlf."', ";
    $sqlUpdateProveedor .= "`email`='".$email."'";
    $sqlUpdateProveedor .= " WHERE `id`=".$id;

    if($mysqli->query($sqlUpdateProveedor)){
        echo 1;
    }else{
        echo 0;
    }
?>