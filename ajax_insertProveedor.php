<?php
    include("db.php");

    $nombre=$_POST["nombre"];
    $cif=$_POST["cif"];
    $calle=$_POST["calle"];
    $cp=$_POST["cp"];
    $ciudad=$_POST["ciudad"];
    $tlf=$_POST["tlf"];
    $email=$_POST["email"];

    $sqlInsertProveedor = "INSERT INTO `proveedores`(`proveedor`, `cif`, `calle`, `cp`, `ciudad`, `telefono`, `email`) VALUES (";
    $sqlInsertProveedor .= "'".$nombre."', ";
    $sqlInsertProveedor .= "'".$cif."', ";
    $sqlInsertProveedor .= "'".$calle."', ";
    $sqlInsertProveedor .= "'".$cp."', ";
    $sqlInsertProveedor .= "'".$ciudad."', ";
    $sqlInsertProveedor .= "'".$tlf."', ";
    $sqlInsertProveedor .= "'".$email."'";
    $sqlInsertProveedor .= ")";

    if($mysqli->query($sqlInsertProveedor)){
        echo 1;
    }else{
        echo 0;
    }
?>