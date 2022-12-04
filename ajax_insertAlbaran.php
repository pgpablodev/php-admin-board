<?php
    include("db.php");

    $proveedor = $_POST["proveedor"];
    $numero = $_POST["numero"];
    $fecha = $_POST["fecha"];
    $iva = $_POST["iva"];

    $sqlInsertAlbaran = "INSERT INTO `albaranes` (`idproveedor`, `numalbaran`, `fecha`, `iva`) VALUES (";
    $sqlInsertAlbaran .= "'".$proveedor."', ";
    $sqlInsertAlbaran .= "'".$numero."', ";
    $sqlInsertAlbaran .= "'".$fecha."', ";
    $sqlInsertAlbaran .= "'".$iva."'";
    $sqlInsertAlbaran .= ")";

    if($mysqli->query($sqlInsertAlbaran)){
        echo 1;
    }else{
        echo 0;
    }
?>