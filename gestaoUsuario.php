<?php include 'inc/header.php'; 
include 'classes/usuario.php';
include 'classes/funcoes.php';

$contato = new Usuario();
$funcao = new Funcoes();

?>

<h1>Usuario Senac 2025</h1>

<table border="2" width="100%">
    <tr>
        <th>ID</th>
        <th>NOME</th>
        <th>EMAIL</th>
        <th>PERMISSOES</th>
        <th>AÇÕES</th>
    </tr>
    <?php
    $lista = $contato->listar();
    foreach($lista as $item):
    ?>
    <tbody>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['nome']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['permissoes']; ?></td>
            <td>
                <button><a href="adicionarUsuario.php">Adicionar</a></button>
                <button><a href="index.php">Home</a></button>
                <button><a href="editarUsuario.php?id=<?php echo $item['id'] ?>">Editar</a></button>
                <button><a href="excluirUsuario.php?id=<?php echo $item['id'] ?>" onclick="return confirm('Deseja realmente excluir esse contato?')">Excluir</a></button>
            </td>
        </tr>
    </tbody>
    <?php 
        endforeach;
     ?>
</table>

<?php include 'inc/footer.php'; ?>