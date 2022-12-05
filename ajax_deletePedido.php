<?php
    include("db.php");
    $id=$_POST["id"];
    $idAlbaran = $_POST["idAlbaran"];

    $sqlTotalPedido = "SELECT `total` FROM `pedidos` WHERE `id`=".$id;
    $resTP = $mysqli->query($sqlTotalPedido);
    if($resTP->num_rows>0){
        while($filaTP = $resTP->fetch_assoc()){
            $totalPedido = $filaTP["total"];
        }
    }

    $sqlBaseAlbaran = "SELECT `baseimponible` FROM `albaranes` WHERE `id`=".$idAlbaran;
    $resBA = $mysqli->query($sqlBaseAlbaran);
    if($resBA->num_rows>0){
        while($filaBA = $resBA->fetch_assoc()){
            $baseAlbaran = $filaBA["baseimponible"];
        }
    }

    $sqlActualizaAlbaran="UPDATE `albaranes` SET `baseimponible`=".($baseAlbaran - $totalPedido).", `total`=(`iva`*".($baseAlbaran - $totalPedido).")+".($baseAlbaran - $totalPedido)." WHERE id=".$idAlbaran;

    $sqlDeletePedido = "DELETE FROM `pedidos` WHERE `id`=".$id;
    $sqlDeleteLineas = "DELETE FROM `lineaspedido` WHERE `idpedido`=".$id;

    if($mysqli->query($sqlActualizaAlbaran) && $mysqli->query($sqlDeletePedido) && $mysqli->query($sqlDeleteLineas)){
        echo 1;
    }else{
        echo 0;
    }
?>