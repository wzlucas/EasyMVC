<?php
    require_once('../dao/tipo_turismoDao.php');
    $obj=null;
    if(isset($_GET['id']))
        $obj=(new tipo_turismoDao())->buscaPorId($_GET['id']);
    $acao=$obj?3:1;
?>
<html>
<head>
    <title>Cadastro de tipo_turismo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<form action="../control/tipo_turismoControl.php?a=<?php echo $acao; ?>" method="post">
<h1>Cadastro de tipo_turismo</h1>
<label for='id'>id</label>
<input type='text' value='<?php echo $obj?$obj['id']:'';?>' name='id'><br>
<label for='nome'>nome</label>
<input type='text' value='<?php echo $obj?$obj['nome']:'';?>' name='nome'><br>

<input type="hidden" name="id" value="<?php echo $obj?$obj['id']:''; ?>">
<button type="submit">Enviar</button>
</form>
</body>
</html>