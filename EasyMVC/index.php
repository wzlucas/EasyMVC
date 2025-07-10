<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Conexão</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php
$bancos = [];

if (isset($_POST['listar']) && isset($_POST['servidor']) && isset($_POST['usuario'])) {
    try {
        $conTemp = new PDO("mysql:host=" . $_POST['servidor'], $_POST['usuario'], $_POST['senha']);
        $resultado = $conTemp->query("SHOW DATABASES");
        $bancos = $resultado->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $bancos = [];
    }
}
?>
<div class="container">
<form action="" method="POST">
    <?php
    include 'mensagens.php';
    if (isset($_GET['msg']) ){
        $msg = $_GET['msg'];
        $classe = $msg == 2 ? 'mensagem' : 'mensagem_erro';
        echo "<div class=\"$classe\">" . ($mensagens[$msg] ?? "Erro desconhecido") . "</div>";
    }
    ?>

    <h1>EasyMVC</h1><h2>Configuração</h2>

    <label for="servidor">Servidor:</label>
    <input type="text" id="servidor" name="servidor" value="<?= $_POST['servidor'] ?? 'localhost' ?>" required>

    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" value="<?= $_POST['usuario'] ?? 'root' ?>" required>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" value="<?= $_POST['senha'] ?? '' ?>">

    <?php if (count($bancos) > 0): ?>
        <label for="banco">Banco de Dados:</label>
        <select name="banco" id="banco" required>
            <option value="">Selecione...</option>
            <?php foreach ($bancos as $banco): ?>
                <option value="<?= $banco ?>"><?= $banco ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit" formaction="creator.php">Enviar</button>
    <?php else: ?>
        <button type="submit" name="listar">Listar Bancos</button>
    <?php endif; ?>
</form>
</div>
</body>
</html>
