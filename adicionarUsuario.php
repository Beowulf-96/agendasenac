<?php require 'inc/header.php'; ?>

<h1>Adicionar Usuário</h1>
<form method="POST" action="adicionarUsuarioSubmit.php">
    Nome: <br>
    <input type="text" name="nome"/> <br><br>
    Email: <br>
    <input type="email" name="email"/> <br><br>
    Senha: <br>
    <input type="senha" name="senha"/> <br><br>
    Permissões: <br>
    <label><input type="checkbox" name="permissoes[]" value="adicionar"> Adicionar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="editar"> Editar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="deletar"> Deletar</label><br>
    <label><input type="checkbox" name="permissoes[]" value="super"> Super</label><br><br>

    <div class="but"><input type="submit" value="Adicionar Usuário"/></div>

</form>

<?php require 'inc/footer.php'; ?>