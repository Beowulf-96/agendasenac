<?php
    session_start();
    include "classes/usuario.php";
    $con =  new Usuario();
    
    if(!empty($_GET["id"])) {
        $id = $_GET["id"];
        $con->deletar($id);
        header("Location: gestaoUsuario.php");
    } else {
        echo "<script type='text/javascript'>alert('Erro ao excluir usuário!!'); </script>";
        header("Location: gestaoUsuario.php");
    }
    ?>