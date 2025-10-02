<?php
    require_once('../dao/empresasDao.php');
    $obj=null;
    if(isset($_GET['id']))
        $obj=(new empresasDao())->buscaPorId($_GET['id']);
    $acao=$obj?3:1;
?>
<html>
<head>
    <title>Cadastro de empresas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<form action="../control/empresasControl.php?a=<?php echo $acao; ?>" method="post">
<h1>Cadastro de empresas</h1>
<label for='id'>id</label>
<input type='text' value='<?php echo $obj?$obj['id']:'';?>' name='id'><br>
<label for='nome'>nome</label>
<input type='text' value='<?php echo $obj?$obj['nome']:'';?>' name='nome'><br>
<label for='descricao'>descricao</label>
<input type='text' value='<?php echo $obj?$obj['descricao']:'';?>' name='descricao'><br>
<label for='telefone'>telefone</label>
<input type='text' value='<?php echo $obj?$obj['telefone']:'';?>' name='telefone'><br>
<label for='email'>email</label>
<input type='text' value='<?php echo $obj?$obj['email']:'';?>' name='email'><br>
<label for='id_tipo'>id_tipo</label>
<input type='text' value='<?php echo $obj?$obj['id_tipo']:'';?>' name='id_tipo'><br>
<label for='id_cidade'>id_cidade</label>
<input type='text' value='<?php echo $obj?$obj['id_cidade']:'';?>' name='id_cidade'><br>

<input type="hidden" name="id" value="<?php echo $obj?$obj['id']:''; ?>">
<button type="submit">Enviar</button>
</form>
</body>
</html>