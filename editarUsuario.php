<?php 
session_start();
require 'inc/header.php'; 
include 'classes/usuario.php';
$contato = new Usuario();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $info = $contato->buscar($id);
    $permissoes = isset($info['permissoes']) ? explode(',', $info['permissoes']) : '';
    if(empty($info['email'])){
        header("Location: gestaoUsuario.php");
        exit;
    }
}else{
    header("Location: gestaoUsuario.php");
    exit;
}


?>

<h1>Editar Usuário</h1>
<form method="POST" action="editarUsuarioSubmit.php">
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Nome: <br>
    <input type="text" name="nome" value="<?php echo $info['nome']; ?>" /> <br><br>
    Email: <br>
    <input type="email" name="email" value="<?php echo $info['email']; ?>" /> <br><br>
    Permissões: <br>
    <label><input type="checkbox" name="permissoes[]" value="adicionar" <?php if( in_array('adicionar', $permissoes))echo "checked"; ?>> Adicionar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="editar" <?php if( in_array('editar', $permissoes))echo "checked"; ?>> Editar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="deletar" <?php if( in_array('deletar', $permissoes))echo "checked"; ?>> Deletar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="super" <?php if( in_array('super', $permissoes))echo "checked"; ?>> Super</label><br><br>
    <div class="but"><input type="submit" value="Editar usuário"/></div>

</form>

<?php require 'inc/footer.php'; ?>