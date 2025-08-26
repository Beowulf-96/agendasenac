<?php include 'inc/header.php'; 
include 'classes/contatos.php';

$contato = new Contato();

?>

<h1>Agenda Senac 2025</h1>
<button><a href="adicionarContato.php">ADICIONAR</a></button>

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
            <td><?php echo $item['id_contatos']; ?></td>
            <td><?php echo $item['nome']; ?></td>
            <td><?php echo $item['endereco']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['telefone']; ?></td>
            <td><?php echo $item['redesocial']; ?></td>
            <td><?php echo $item['profissao']; ?></td>
            <td><?php echo $item['datanasc']; ?></td>
            <td><?php echo $item['foto']; ?></td>
            <td><?php echo $item['ativo']; ?></td>
            <td>
                <button><a href="editarContato.php?id_contatos=<?php echo $item['id_contatos'] ?>"> EDITAR</a></button>
                <button><a href="#">| EXCLUIR</a></button>
            </td>
        </tr>
    </tbody>
    <?php 
        endforeach;
     ?>
</table>

<?php include 'inc/footer.php'; ?>