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
    $id = base64_decode($_GET["id"]);

    $out = fopen('pedido'.$id.'.csv', 'w');
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    $arrayCsv = array();
    $arrayCsv[] = array("ID pedido", "ID albarán", "Producto", "Precio");

    $sqlPedido = "SELECT `pedidos`.`idalbaran` FROM `pedidos` INNER JOIN `albaranes` ON `pedidos`.`idalbaran`=`albaranes`.`id`";                                
    $result = $mysqli->query($sqlPedido);
    if($result->num_rows>0){
        while($fila=$result->fetch_assoc()){
            $idalbaran = $fila["idalbaran"];
            $sqlLineasPedido = "SELECT `producto`, `precio` FROM `lineaspedido` WHERE `idpedido`=".$id;            
        }
        $result2 = $mysqli->query($sqlLineasPedido);
        if($result2->num_rows>0){
            while($fila2=$result2->fetch_assoc()){
                $producto = $fila2["producto"];
                $precio = $fila2["precio"];
                $arrayCsv[] = array($id, $idalbaran, $producto, $precio);
            }
        }
    }

    for($i=0;$i<count($arrayCsv);$i++){
        fputcsv($out, $arrayCsv[$i],";");   
    }    

    fclose($out);
    header("location:pedidos.php");
?>