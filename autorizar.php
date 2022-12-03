<?php
    include("db.php");
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sql = "SELECT `id`, `usuario`, `password` FROM `usuarios` WHERE 1";
    $sql.= " AND `usuario`='".$usuario."'";
    $sql.= " AND `password`='".md5($password)."'";

    $result = $mysqli->query($sql);

    if($result->num_rows>0){
        $fila=$result->fetch_assoc();
        $id = $fila["id"];
        $usuario = $fila["usuario"];
        $password = $fila["password"];
        session_start();
        $_SESSION["validado"] = "1";
        $_SESSION["usuario"] = $usuario;
        header("location:pricing.php");
    }else{
        header("location:login.php?error=1&mensaje=Usuario o contraseña incorrectos&usuario=".base64_encode($usuario)."&password=".($password));
    }
?>