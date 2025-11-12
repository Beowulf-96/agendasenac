<?php 
require 'inc/header.php'; 
include 'classes/contatos.php';
$contato = new Contato();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $info = $contato->buscar($id);
    if(empty($info['email'])){
        header("Location: /agendaSenac2025");
        exit;
    }
}else{
    header("Location: /agendaSenac2025");
    exit;
}

if(!empty ($_POST['id'])) {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $redeSocial = $_POST['redeSocial'];
    $profissao = $_POST['profissao'];
    $dataNasc = $_POST['dataNasc'];
    if(isset($_FILES['foto'])) {
        $foto = $_FILES['foto'];
    } else {
        $foto = array();
    }
    //$foto = $_POST['foto'];
    $ativo = $_POST['ativo'];
    $id = $_POST['id'];
    if(!empty($email)) {
    $contato->editar($id, $nome, $endereco, $email, $telefone, $redeSocial, $profissao, $dataNasc, $foto, $ativo, $_GET['id']);
    }

    header("Location: /agendaSenac2025");
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $info = $contato->getContato($_GET['id']);
}  else {
    ?>
        <script type="text/javascript">window.location. 
        href= "index.php"; </script>
    <?php
    exit;
}

?>

<h1>EDITAR CONTATO</h1>
<form method="POST" enctype="multipart/form-data"> <!--permite adicionar imagens no form -->
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Nome: <br>
    <input type="text" name="nome" value="<?php echo $info['nome']; ?>" /> <br><br>
    Endereço: <br>
    <input type="text" name="endereco" value="<?php echo $info['endereco']; ?>" /> <br><br>
    Email: <br>
    <input type="email" name="email" value="<?php echo $info['email']; ?>" /> <br><br>
    Telefone: <br>
    <input type="text" name="telefone" value="<?php echo $info['telefone']; ?>"/> <br><br>
    Rede Social: <br>
    <input type="text" name="redeSocial" value="<?php echo $info['redeSocial']; ?>"/> <br><br>
    Profissão: <br>
    <input type="text" name="profissao" value="<?php echo $info['profissao']; ?>"/> <br><br>
    Data de Nascimento: <br>
    <input type="date" name="dataNasc" value="<?php echo $info['dataNasc']; ?>"/> <br><br>
    Foto: <br>
    <input type="file" name="foto[]" multiple/> <br><br>
    <div class="grupo">
        <div class="cabecalho">Foto Contato</div>
        <div class="corpo">
            <?php foreach($info['foto'] as $fotos):?>
                <div class="foto_item">
                    <img src="image/contatos/<?php echo $fotos['url'];?>"/>
                    <a href="excluir_foto.php?id=<?php echo $fotos['id'];?>">Excluir Imagem </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    Ativo: <br>
    <input type="text" name="ativo" value="<?php echo $info['ativo']; ?>"/> <br><br>

    <div class="but"><input type="submit" value="Editar contato"/></div>

</form>

<?php require 'inc/footer.php'; ?>