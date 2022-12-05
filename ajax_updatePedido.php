<?php
    include("db.php");
    include("funciones.php");

    $id = $_POST["id"];
    $albaran = $_POST["albaran"];

    $contadorLineas = $_POST["contadorLineas"];
    $lineasViejas = $_POST["lineasViejas"];
    
    $sqlUpdatePedido = "UPDATE `pedidos` SET `idalbaran`='".$albaran."' WHERE `id`=".$id;
    $total = 0;
    
    if($mysqli->query($sqlUpdatePedido)){

        for($i=0;$i<$lineasViejas;$i++){
            $idLinea = $_POST["idLinea".$i];
            $producto = $_POST["producto".$i];
            $precio = $_POST["precio".$i];
            $total = $total + $precio;

            $sqlUpdateLineaPedido = "UPDATE `lineaspedido` SET `idpedido`='";
            $sqlUpdateLineaPedido .= $id."', ";
            $sqlUpdateLineaPedido .= "`producto`='".$producto."', ";
            $sqlUpdateLineaPedido .= "`precio`='".$precio."' WHERE `id`=".$idLinea;  

            if($producto!="")  $mysqli->query($sqlUpdateLineaPedido);
        }
        
        for($i=$lineasViejas;$i<$contadorLineas;$i++){
            $producto = $_POST["producto".$i];
            $precio = $_POST["precio".$i];
            $total = $total + $precio;

            $sqlInsertLineaPedido = "INSERT INTO `lineaspedido`(`idpedido`, `producto`, `precio`) VALUES (";
            $sqlInsertLineaPedido.="'".$id."'";
            $sqlInsertLineaPedido.=",'".$producto."'";
            $sqlInsertLineaPedido.=",'".$precio."'";
            $sqlInsertLineaPedido.=")";

            if($producto!="")  $mysqli->query($sqlInsertLineaPedido);
        }
        $sqlActualizaTotal="UPDATE `pedidos` SET `total`='".$total."' WHERE id=".$id;

        $sqlTotalAlbaran = "SELECT SUM(`total`) as `suma` FROM `pedidos` WHERE `idalbaran`=".$albaran;
        $resTotalAlbaran = $mysqli->query($sqlTotalAlbaran);
        if($resTotalAlbaran->num_rows>0){
            while($filaAlbaran=$resTotalAlbaran->fetch_assoc()){
                $totalAlbaran = $filaAlbaran["suma"];
            }
        }

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