<?php
include 'classes/contatos.php';
$contato = new Contato();

if(!empty ($_POST['email'])) {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $redesocial = $_POST['redesocial'];
    $profissao = $_POST['profissao'];
    $datanasc = $_POST['datanasc'];
    $foto = $_POST['foto'];
    $ativo = $_POST['ativo'];
    $contato->adicionar($email, $nome, $endereco, $telefone, $redesocial, $profissao, $datanasc, $foto, $ativo);
    header("Location: index.php");
} else {
    echo '<script type="text/javascript">alert("Email ja cadastrado!");</script>';
}

