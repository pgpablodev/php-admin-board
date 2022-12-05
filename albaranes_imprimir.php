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
    include("funciones.php");
    $tipodocumento="ALBARAN";
    $margen="10pt";
    $columna1="190pt";
    $columna2="190pt";
    $columna="400pt";
    ob_start();
?>

<style>
    @page{
        width: 595pt;
        height: 842pt;
    }
    *{
        margin: 0;
        padding: 0;
    }
</style>

<!doctype html>
<html lang="en">
    <body style="font-family: Arial, Helvetica, sans-serif;">
        <div style="margin-left: 100px; margin-top: 40px;">
            <table style="border-collapse: collapse; margin-left: 10px;">
                <thead>
                    <tr>
                        <th colspan="2" style="padding: 10px; text-align: center">Datos albarán</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $id = base64_decode($_GET["id"]);
                        include("db.php");
                        $sqlAlbaran = "SELECT `proveedores`.`proveedor`, `numalbaran`, `fecha`, `baseimponible`, `iva`, `total` FROM albaranes INNER JOIN `proveedores` ON `albaranes`.`idproveedor`=`proveedores`.`id` WHERE `albaranes`.`id`=".$id;
                        $result = $mysqli->query($sqlAlbaran);
                        if($result->num_rows>0){
                            while($fila = $result->fetch_assoc()){
                                $proveedor = $fila["proveedor"];
                                $numalbaran = $fila["numalbaran"];
                                $fecha = $fila["fecha"];
                                $baseimponible = $fila["baseimponible"];
                                $iva = $fila["iva"];
                                $total = $fila["total"];
                                ?>
                                    <tr>
                                        <td>Proveedor</td>
                                        <td style="text-align: right; padding-bottom: 5px;"><?php echo $proveedor;?></td>
                                    </tr>
                                    <tr>
                                        <td>Núm. albarán</td>
                                        <td style="text-align: right; padding-bottom: 5px;"><?php echo $numalbaran;?></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha</td>
                                        <td style="text-align: right; padding-bottom: 5px;"><?php echo $fecha;?></td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
            <br>
            <table style="border-collapse: collapse; margin-left: 10px;">
                <thead>
                    <tr>
                        <th colspan="2" style="padding-top: 60px; padding-bottom: 10px; text-align: left">Artículos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $id = base64_decode($_GET["id"]);
                        include("db.php");
                        $sqlPedido = "SELECT `id` FROM pedidos WHERE `idalbaran`=".$id;
                        $result = $mysqli->query($sqlPedido);
                        if($result->num_rows>0){
                            while($fila = $result->fetch_assoc()){
                                $idPedido = $fila["id"];
                                $sqlLineas = "SELECT `producto`, `precio` FROM `lineaspedido` WHERE `idpedido`=".$idPedido;
                                $result2 = $mysqli->query($sqlLineas);
                                if($result2->num_rows>0){
                                    while($fila2 = $result2->fetch_assoc()){
                                        $producto = $fila2["producto"];
                                        $precio = $fila2["precio"];
                                        ?>
                                            <tr>
                                                <td style="padding-bottom: 20px; padding-right: 400px;"><?php echo $producto; ?></td>
                                                <td style="padding-bottom: 20px; text-align: right;"><?php echo $precio; ?> €</td>
                                            </tr>
                                        <?php
                                    }
                                }                            
                            }
                            ?>
                                <tr>
                                    <td style="padding-top: 20px; padding-bottom: 20px; padding-left: 400px; text-align: right;">Subtotal</td>
                                    <td style="padding-top: 20px; padding-bottom: 20px; padding-left: 60px; text-align: right;"><?php echo $baseimponible?> €</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 20px; padding-left: 400px; text-align: right;">IVA</td>
                                    <td style="padding-bottom: 20px; padding-left: 60px; text-align: right;"><?php echo ($iva*100)?> %</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 20px; padding-left: 400px; text-align: right;">Total</td>
                                    <td style="padding-bottom: 20px; padding-left: 60px; text-align: right;"><?php echo $total?> €</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

<?php
  require_once 'dompdf/autoload.inc.php';
  use Dompdf\Dompdf;
  $dompdf=new DOMPDF();
  $dompdf->load_html(ob_get_clean());
  $dompdf->render();
  $pdf=$dompdf->output();
  $filename = $tipodocumento.$numalbaran.".pdf";
  file_put_contents($filename,$pdf);
  $dompdf->stream($filename,array('Attachment'=>0)); //,array('Attachment'=>0) para que no se descargue automaticamente
?>