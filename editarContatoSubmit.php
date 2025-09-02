<?php
include 'classes/contatos.php';
$contato = new Contato();

if(!empty ($_POST['id'])) {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $redeSocial = $_POST['redeSocial'];
    $profissao = $_POST['profissao'];
    $dataNasc = $_POST['dataNasc'];
    $foto = $_POST['foto'];
    $ativo = $_POST['ativo'];
    $id = $_POST['id'];

    if(!empty($email)) {
    $contato->editar($id, $nome, $endereco, $email, $telefone, $redeSocial, $profissao, $dataNasc, $foto, $ativo);
    }

    header("Location: /agendaSenac2025");
}

