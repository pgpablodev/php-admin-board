<?php
    include("db.php");
    $id=$_POST["id"];

    $sqlDeleteProveedor = "DELETE FROM `proveedores` WHERE `id`=".$id;

    if($mysqli->query($sqlDeleteProveedor)){
        echo 1;
    }else{
        echo 0;
    }
?>