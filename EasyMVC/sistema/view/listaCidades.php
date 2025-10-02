<html>
<head>
    <title>Lista de cidades</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<?php
require_once("../dao/cidadesDao.php");
$dao=new cidadesDao();
$dados=$dao->listaGeral();
echo "<table border=1>";
foreach($dados as $dado){
    echo "<tr>";
    echo "<td>{$dado['id']}</td>";
echo "<td>{$dado['nome']}</td>";

    echo "<td><a href='../control/cidadesControl.php?id={$dado['id']}&a=2'>Excluir</a></td>";
    echo "<td><a href='../view/cidades.php?id={$dado['id']}'>Alterar</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>