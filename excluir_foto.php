<?php
    session_start();
    include "classes/contatos.php";
    $con =  new Contato();
    
    if(!empty($_GET["id"])) {
        $id = $_GET["id"];
        $con->deletarFoto($id);
        header("Location: index.php");
    } else {
        echo "<script type='text/javascript'>alert('Erro ao excluir foto!!'); </script>";
        header("Location: gestaoUsuario.php");
    }
    ?>