<?php 
session_start();
include 'inc/header.php'; 
include 'classes/contatos.php';
include 'classes/funcoes.php';
include 'classes/usuario.php';

if(!isset($_SESSION['logado'])){
    header('Location: login.php');
    exit;
}

$usuarios = new Usuario();
$usuarios->setUsuario($_SESSION['logado']);
$contato = new Contato();
$funcao = new Funcoes();
//session_start();
//print_r($_SESSION);

?>

<main>
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
                    <?php if($usuarios->temPermissao("adicionar")): ?>
                    <button><a href="adicionarContato.php">adicionar</a></button>
                    <?php endif; ?>

                    <?php if($usuarios->temPermissao("super")): ?>
                    <button><a href="gestaoUsuario.php">Usuário</a></button>
                    <?php endif; ?>

                    <?php if($usuarios->temPermissao("editar")): ?>
                    <button><a href="editarContato.php?id=<?php echo $item['id'] ?>"> Editar</a></button>
                    <?php endif; ?>

                    <?php if($usuarios->temPermissao("excluir")): ?>
                    <button><a href="excluirContato.php?id=<?php echo $item['id'] ?>" onclick="return confirm('Deseja realmente excluir esse contato?')">Excluir</a></button>
                    <?php endif; ?>

                    <button><a href="sair.php">Sair</a></button>
                </td>
            </tr>
        </tbody>
        <?php 
            endforeach;
        ?>
    </table>
        </main>

<?php include 'inc/footer.php'; ?>