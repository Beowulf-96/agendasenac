<?php include 'inc/header.php'; 
include 'classes/contatos.php';
include 'classes/funcoes.php';

$contato = new Contato();
$funcao = new Funcoes();

?>

<h1>Agenda Senac 2025</h1>
<button><a href="adicionarContato.php">ADICIONAR</a></button>
<button><a href="usuario.php">Usuário</a></button>
<table border="2" width="100%">
    <tr>
        <th>ID</th>
        <th>NOME</th>
        <th>ENDEREÇO</th>
        <th>EMAIL</th>
        <th>TELEFONE</th>
        <th>REDE SOCIAL</th>
        <th>PROFISSÃO</th>
        <th>DATA NASCIMENTO</th>
        <th>FOTO</th>
        <th>ATIVO</th>
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
            <td><?php echo $item['endereco']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['telefone']; ?></td>
            <td><?php echo $item['redeSocial']; ?></td>
            <td><?php echo $item['profissao']; ?></td>
            <td><?php echo $funcao->dataNasc($item['dataNasc'], 2); ?></td>
            <td><?php echo $item['foto']; ?></td>
            <td><?php echo $item['ativo']; ?></td>
            <td>
                <button><a href="editarContato.php?id=<?php echo $item['id'] ?>"> EDITAR</a></button>
                <button><a href="excluirContato.php?id=<?php echo $item['id'] ?>" onclick="return confirm('Deseja realmente excluir esse contato?')">EXCLUIR</a></button>
            </td>
        </tr>
    </tbody>
    <?php 
        endforeach;
     ?>
</table>

<?php include 'inc/footer.php'; ?>