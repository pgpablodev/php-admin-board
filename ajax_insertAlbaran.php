<?php
    include("db.php");

    $proveedor = $_POST["proveedor"];
    $numero = $_POST["numero"];
    $fecha = $_POST["fecha"];
    $iva = $_POST["iva"];
    $total = $base+$base*$iva;

    $sqlInsertAlbaran = "INSERT INTO `albaranes` (`idproveedor`, `numalbaran`, `fecha`, `iva`, `total`) VALUES (";
    $sqlInsertAlbaran .= "'".$proveedor."', ";
    $sqlInsertAlbaran .= "'".$numero."', ";
    $sqlInsertAlbaran .= "'".$fecha."', ";
    $sqlInsertAlbaran .= "'".$iva."', ";
    $sqlInsertAlbaran .= "'".$total."'";
    $sqlInsertAlbaran .= ")";

    if($mysqli->query($sqlInsertAlbaran)){
        echo 1;
    }else{
        echo 0;
    }
?>