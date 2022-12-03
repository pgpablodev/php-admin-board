<?php
    function conseguirValor($tabla, $campo, $where, $valor){
        include("db.php");
        $respuesta="";
        $sql = "SELECT ".$campo." FROM ".$tabla." WHERE ".$where."='".$valor."'";
        $result = $mysqli->query($sql);
        if($result->num_rows>0){
            while($fila=$result->fetch_assoc()){
                $respuesta = $fila[$campo];
            }
        }        
        return $respuesta;
    }

    function crearLista($tabla, $val, $mostrar, $sel){
        include("db.php");
        $respuesta = "<option value=''></option>";
        $sql = "SELECT ".$val.",".$mostrar." FROM ".$tabla;
        $sql.= " WHERE 1 ORDER BY ".$mostrar;
        $result =$mysqli->query($sql);
        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $id = $fila[$val];
                $texto = $fila[$mostrar];
                $selected = '';
                if($sel==$id) $selected = 'selected';
                $respuesta.="<option value='".$id."' ".$selected.">".$texto."</option>";
            }
        }
        echo $respuesta;
    }

    function crearLista2Campos($tabla, $val, $mostrar, $mostrar2, $separador, $sel){
        include("db.php");
        $respuesta = "<option value=''></option>";
        $sql = "SELECT ".$val.",".$mostrar.",".$mostrar2." FROM ".$tabla;
        $sql.= " WHERE 1 ORDER BY ".$mostrar;
        $result =$mysqli->query($sql);
        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $id = $fila[$val];
                $texto = $fila[$mostrar];
                $texto2 = $fila[$mostrar2];
                $selected = '';
                if($sel==$id) $selected = 'selected';
                $respuesta.="<option value='".$id."' ".$selected.">".$texto.$separador.$texto2."</option>";
            }
        }
        echo $respuesta;
    }
?>