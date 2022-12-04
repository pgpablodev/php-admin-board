<?php
    include("db.php");

    $id = base64_decode($_POST["id"]);

    $proveedor=$_POST["proveedor"];
    $numero=$_POST["numero"];
    $fecha=$_POST["fecha"];
    $iva=$_POST["iva"];

    $sqlUpdateProveedor = "UPDATE `albaranes` SET ";
    $sqlUpdateProveedor .= "`idproveedor`='".$proveedor."', ";
    $sqlUpdateProveedor .= "`numalbaran`='".$numero."', ";
    $sqlUpdateProveedor .= "`fecha`='".$fecha."', ";
    $sqlUpdateProveedor .= "`iva`='".$iva."'";
    $sqlUpdateProveedor .= " WHERE `id`=".$id;

    if($mysqli->query($sqlUpdateProveedor)){
        echo 1;
    }else{
        echo 0;
    }
?>