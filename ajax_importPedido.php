<?php
    session_start();
    if(isset($_SESSION["validado"])){
        if($_SESSION["validado"]!="1")
        header("location:login.php");
    }else{
        header("location:login.php");
    }
?>

<?php
    include("db.php");

    $sqlTotalAlbaran = "SELECT `baseimponible` FROM `albaranes` WHERE `id`=".$_POST["idAlbaran"];
    $resultSqlTA = $mysqli->query($sqlTotalAlbaran);
    if($resultSqlTA->num_rows>0){
        while($fila=$resultSqlTA->fetch_assoc()){
            $totalAlbaran = $fila["baseimponible"];
        }
    }

    $total = 0;
    
    if(file_exists("lineaspedido.csv")){
        $fp=fopen("lineaspedido.csv","r");
        $numlineas=0;
        while($data=fgetcsv($fp,1000,";")){
            if($numlineas>0){
                $producto = utf8_encode($data[0]);
                $precio = $data[1];
                $total += $precio;
                $sqlInsertPedido = "INSERT INTO `lineaspedido`(`idpedido`, `producto`, `precio`) VALUES (";
                $sqlInsertPedido.="'".$_POST["id"]."'";
                $sqlInsertPedido.=",'".$producto."'";
                $sqlInsertPedido.=",'".$precio."'";
                $sqlInsertPedido .= ")";
                $mysqli->query($sqlInsertPedido);
            }else{
                if($data[0]!="producto"){
                    echo "error";
                    break;
                }
            }
            $numlineas=$numlineas+1;
        }
        fclose($fp);
        $totalAlbaran += $total;
        $sqlActualizaTotal="UPDATE `pedidos` SET `total`='".$total."' WHERE id=".$_POST["id"];
        $sqlActualizaAlbaran="UPDATE `albaranes` SET `baseimponible`='".$totalAlbaran."', `total`=(`iva`*'".$totalAlbaran."')+'".$totalAlbaran."' WHERE id=".$_POST["idAlbaran"];
        if($mysqli->query($sqlActualizaTotal) && $mysqli->query($sqlActualizaAlbaran)){
            echo 1;
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }    
?>