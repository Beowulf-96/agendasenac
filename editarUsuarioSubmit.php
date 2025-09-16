<?php
include 'classes/usuario.php';
$contato = new Usuario();

if(!empty ($_POST['id'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $permissoes = isset($_POST['permissoes']) ? implode(',', $_POST['permissoes']) : '';
    $id = $_POST['id'];

    if(!empty($email)) {
    $contato->editar($id, $nome, $email, $permissoes);
    }

    header("Location: gestaoUsuario.php");
}

