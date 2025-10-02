<?php
    require_once('../dao/cidadesDao.php');
    $obj=null;
    if(isset($_GET['id']))
        $obj=(new cidadesDao())->buscaPorId($_GET['id']);
    $acao=$obj?3:1;
?>
<html>
<head>
    <title>Cadastro de cidades</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<form action="../control/cidadesControl.php?a=<?php echo $acao; ?>" method="post">
<h1>Cadastro de cidades</h1>
<label for='id'>id</label>
<input type='text' value='<?php echo $obj?$obj['id']:'';?>' name='id'><br>
<label for='nome'>nome</label>
<input type='text' value='<?php echo $obj?$obj['nome']:'';?>' name='nome'><br>

<input type="hidden" name="id" value="<?php echo $obj?$obj['id']:''; ?>">
<button type="submit">Enviar</button>
</form>
</body>
</html>