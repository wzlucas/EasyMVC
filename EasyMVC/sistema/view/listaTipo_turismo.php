<html>
<head>
    <title>Lista de tipo_turismo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<?php
require_once("../dao/tipo_turismoDao.php");
$dao=new tipo_turismoDao();
$dados=$dao->listaGeral();
echo "<table border=1>";
foreach($dados as $dado){
    echo "<tr>";
    echo "<td>{$dado['id']}</td>";
echo "<td>{$dado['nome']}</td>";

    echo "<td><a href='../control/tipo_turismoControl.php?id={$dado['id']}&a=2'>Excluir</a></td>";
    echo "<td><a href='../view/tipo_turismo.php?id={$dado['id']}'>Alterar</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>