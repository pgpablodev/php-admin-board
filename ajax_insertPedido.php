<?php
    include("db.php");
    include("funciones.php");

    $albaran = $_POST["albaran"];

    $contadorLineas = $_POST["contadorLineas"];
    
    $sqlInsertPedido = "INSERT INTO `pedidos`(`idalbaran`) VALUES ('".$albaran."')";
    $total = 0;

    $sqlTotalAlbaran = "SELECT `baseimponible` FROM `albaranes` WHERE `id`=".$albaran;
    $resultSqlTA = $mysqli->query($sqlTotalAlbaran);
    if($resultSqlTA->num_rows>0){
        while($fila=$resultSqlTA->fetch_assoc()){
            $totalAlbaran = $fila["baseimponible"];
        }
    }
    
    if($mysqli->query($sqlInsertPedido)){
        $id_pedido = $mysqli->insert_id;
        for($i=1;$i<=$contadorLineas;$i++){
            $producto = $_POST["producto".$i];
            $precio = $_POST["precio".$i];
            $total += $precio;
            
            $sqlInsertLineaPedido = "INSERT INTO `lineaspedido`(`idpedido`, `producto`, `precio`) VALUES (";
            $sqlInsertLineaPedido.="'".$id_pedido."'";
            $sqlInsertLineaPedido.=",'".$producto."'";
            $sqlInsertLineaPedido.=",'".$precio."'";
            $sqlInsertLineaPedido.=")";

            if($producto!="")  $mysqli->query($sqlInsertLineaPedido);
        }
        $totalAlbaran += $total;
        $sqlActualizaTotal="UPDATE `pedidos` SET `total`='".$total."' WHERE id=".$id_pedido;
        $sqlActualizaAlbaran="UPDATE `albaranes` SET `baseimponible`='".$totalAlbaran."', `total`=(`iva`*'".$totalAlbaran."')+'".$totalAlbaran."' WHERE id=".$albaran;
        if($mysqli->query($sqlActualizaTotal) && $mysqli->query($sqlActualizaAlbaran)){
            echo 1;
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
?>