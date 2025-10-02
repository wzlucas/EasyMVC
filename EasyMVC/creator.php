<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

class Creator {
    private $con;
    private $servidor;
    private $banco;
    private $usuario;
    private $senha;
    private $tabelas;

    function __construct() {
        if(isset($_GET['id']))
            $this->buscaBancodeDados();
        else {
            $this->criaDiretorios();
            $this->conectar(1);
            $this->buscaTabelas();
            $this->ClassesModel();
            $this->ClasseConexao();
            $this->ClassesControl();
            $this->classesView();
            $this->ClassesDao();
            $this->ClasseHome();
            $this->compactar();
            header("Location:index.php?msg=2");
        }
    }

    function criaDiretorios() {
        $dirs = [
            "sistema",
            "sistema/model",
            "sistema/control",
            "sistema/view",
            "sistema/dao",
            "sistema/css"
        ];

        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    header("Location:index.php?msg=0");
                }
            }
        }
        copy('estilos.css','sistema/css/estilos.css');
    }

    function conectar($id){
        $this->servidor = $_REQUEST["servidor"];
        $this->usuario = $_REQUEST["usuario"];
        $this->senha = $_REQUEST["senha"];
        if ($id == 1) {
           $this->banco = $_POST["banco"];
        } else {
            $this->banco = "mysql";
        }
        try {
            $this->con = new PDO(
                "mysql:host=" . $this->servidor . ";dbname=" . $this->banco,
                $this->usuario,
                $this->senha
            );
        } catch (Exception $e) {
           header("Location:index.php?msg=1");
        }
    }

    function buscaBancodeDados(){
        try {
            $this->conectar(0);
            $sql = "SHOW databases";
            $query = $this->con->query($sql);
            $databases = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($databases as $database){
                echo "<option>".$database["Database"]."</option>";
            }
            $this->con=null;
        } catch (Exception $e) {
            header("Location:index.php?msg=3");
        }
    }

    function buscaTabelas(){
       try {
           $sql = "SHOW TABLES";
           $query = $this->con->query($sql);
           $this->tabelas = $query->fetchAll(PDO::FETCH_ASSOC);
       } catch (Exception $e) {
           header("Location:index.php?msg=3");
       }
    }

    function buscaAtributos($nomeTabela){
        $sql="show columns from ".$nomeTabela;
        $atributos = $this->con->query($sql)->fetchAll(PDO::FETCH_OBJ);
        return $atributos;
    }

    function ClassesModel() {
        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array) $tabela)[0];
            $atributos=$this->buscaAtributos($nomeTabela);
            $nomeAtributos="";
            $geters_seters="";
            foreach ($atributos as $atributo) {
                $atributo=$atributo->Field;
                $nomeAtributos.="\tprivate \${$atributo};\n";
                $metodo=ucfirst($atributo);
                $geters_seters.="\tfunction get".$metodo."(){\n";
                $geters_seters.="\t\treturn \$this->{$atributo};\n\t}\n";
                $geters_seters.="\tfunction set".$metodo."(\${$atributo}){\n";
                $geters_seters.="\t\t\$this->{$atributo}=\${$atributo};\n\t}\n";
            }
            $nomeClasse=ucfirst($nomeTabela);
            $conteudo = <<<EOT
<?php
class {$nomeClasse} {
{$nomeAtributos}
{$geters_seters}
}
?>
EOT;
            file_put_contents("sistema/model/{$nomeTabela}.php", $conteudo);
        }
    }

    function ClasseConexao(){
        $conteudo = <<<EOT
<?php
class Conexao {
    private \$server;
    private \$banco;
    private \$usuario;
    private \$senha;
    function __construct() {
        \$this->server = '{$this->servidor}';
        \$this->banco = '{$this->banco}';
        \$this->usuario = '{$this->usuario}';
        \$this->senha = '{$this->senha}';
    }
    function conectar() {
        try {
            \$conn = new PDO(
                "mysql:host=" . \$this->server . ";dbname=" . \$this->banco,\$this->usuario,
                \$this->senha
            );
            return \$conn;
        } catch (Exception \$e) {
            echo "Erro ao conectar com o Banco de dados: " . \$e->getMessage();
        }
    }
}
?>
EOT;
        file_put_contents("sistema/model/conexao.php", $conteudo);
    }

    function ClassesControl(){
        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array)$tabela)[0];
            $atributos=$this->buscaAtributos($nomeTabela);
            $nomeClasse=ucfirst($nomeTabela);
            $posts="";
            foreach ($atributos as $atributo) {
                $atributo=$atributo->Field;
                $posts.= "\$this->{$nomeTabela}->set".ucFirst($atributo)."(\$_POST['{$atributo}']);\n\t\t";
            }

            $conteudo = <<<EOT
<?php
require_once("../model/{$nomeTabela}.php");
require_once("../dao/{$nomeTabela}Dao.php");
class {$nomeClasse}Control {
    private \${$nomeTabela};
    private \$acao;
    private \$dao;
    public function __construct(){
       \$this->{$nomeTabela}=new {$nomeClasse}();
       \$this->dao=new {$nomeClasse}Dao();
       \$this->acao=\$_GET["a"];
       \$this->verificaAcao(); 
    }
    function verificaAcao(){
       switch(\$this->acao){
          case 1:
            \$this->inserir();
            break;
          case 2:
            \$this->excluir();
            break;
          case 3:
            \$this->alterar();
            break;
       }
    }
    function inserir(){
        {$posts}
        \$this->dao->inserir(\$this->{$nomeTabela});
    }
    function excluir(){
        \$this->dao->excluir(\$_REQUEST['id']);
    }
    function alterar(){
        {$posts}
        \$id = \$_POST['id'];
        \$this->dao->alterar(\$this->{$nomeTabela}, \$id);
    }
    function buscarId({$nomeClasse} \${$nomeTabela}){}
    function buscaTodos(){}
}
new {$nomeClasse}Control();
?>
EOT;
            file_put_contents("sistema/control/{$nomeTabela}Control.php", $conteudo);
        }
    }

    function ClassesDao(){
   
        foreach ($this->tabelas as $tabela) {
        $nomeTabela = array_values((array)$tabela)[0];
        $nomeClasse = ucfirst($nomeTabela);
        $atributos = $this->buscaAtributos($nomeTabela);
        $id = "";
        $set = "";
        $valoresGet = "";

        foreach ($atributos as $atributo) {
            if ($atributo->Key == "PRI") {
                $id = $atributo->Field;
            } else {
                $campo = $atributo->Field;
                $set .= "$campo = ?, ";
                $metodo = ucfirst($campo);
                $valoresGet .= "\$valores[] = \$obj->get{$metodo}();\n\t\t";
            }
        }

        $set = rtrim($set, ", ");

        $atributos = array_map(function($obj) {
            return $obj->Field;
        }, $atributos);
        $sqlCols = implode(', ', $atributos);
        $placeholders = implode(', ', array_fill(0, count($atributos), '?'));

        $vetAtributos = [];
        $AtributosMetodos = "";
        foreach ($atributos as $atributo) {
            $atr = ucfirst($atributo);
            array_push($vetAtributos, "\${$atributo}");
            $AtributosMetodos .= "\${$atributo} = \$obj->get{$atr}();\n\t\t";
        }
        $atributosOk = implode(",", $vetAtributos);

        $conteudo = <<<EOT
<?php
require_once("../model/conexao.php");
class {$nomeClasse}Dao {
    private \$con;
    public function __construct(){
       \$this->con = (new Conexao())->conectar();
    }
    function inserir(\$obj) {
        \$sql = "INSERT INTO {$nomeTabela} ({$sqlCols}) VALUES ({$placeholders})";
        \$stmt = \$this->con->prepare(\$sql);
        {$AtributosMetodos}
        \$stmt->execute([{$atributosOk}]);
        header("Location:../view/lista{$nomeClasse}.php");
    exit;
    }
    function listaGeral(){
        \$sql = "SELECT * FROM {$nomeTabela}";
        \$query = \$this->con->query(\$sql);
        return \$query->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscaPorId(\$id){
        \$sql = "SELECT * FROM {$nomeTabela} WHERE {$id} = ?";
        \$stmt = \$this->con->prepare(\$sql);
        \$stmt->execute([\$id]);
        return \$stmt->fetch(PDO::FETCH_ASSOC);
    }
    function excluir(\$id){
        \$sql = "DELETE FROM {$nomeTabela} WHERE {$id} = ?";
        \$stmt = \$this->con->prepare(\$sql);
        \$stmt->execute([\$id]);
        header("Location:../view/lista{$nomeClasse}.php");
    }
    function alterar(\$obj, \$id){
        \$sql = "UPDATE {$nomeTabela} SET {$set} WHERE {$id} = ?";
        \$stmt = \$this->con->prepare(\$sql);
        \$valores = [];
        {$valoresGet}
        \$valores[] = \$id;
        \$stmt->execute(\$valores);

        header("Location:../view/lista{$nomeClasse}.php");
    exit;
    }
}
?>
EOT;
        file_put_contents("sistema/dao/{$nomeTabela}Dao.php", $conteudo);
    }
}

    function classesView() {
        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array)$tabela)[0];
            $atributos=$this->buscaAtributos($nomeTabela);
            $formCampos="";
            $id="";
            foreach ($atributos as $atributo) {
                $atributo=$atributo->Field;
                if($atributo=="id") $id=$atributo;
                $formCampos .= "<label for='{$atributo}'>{$atributo}</label>\n";
                $formCampos .= "<input type='text' value='<?php echo \$obj?\$obj['{$atributo}']:'';?>' name='{$atributo}'><br>\n";
            }
            $conteudo = <<<HTML
<?php
    require_once('../dao/{$nomeTabela}Dao.php');
    \$obj=null;
    if(isset(\$_GET['id']))
        \$obj=(new {$nomeTabela}Dao())->buscaPorId(\$_GET['id']);
    \$acao=\$obj?3:1;
?>
<html>
<head>
    <title>Cadastro de {$nomeTabela}</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<form action="../control/{$nomeTabela}Control.php?a=<?php echo \$acao; ?>" method="post">
<h1>Cadastro de {$nomeTabela}</h1>
{$formCampos}
<input type="hidden" name="id" value="<?php echo \$obj?\$obj['{$id}']:''; ?>">
<button type="submit">Enviar</button>
</form>
</body>
</html>
HTML;
            file_put_contents("sistema/view/{$nomeTabela}.php", $conteudo);
        }

        foreach ($this->tabelas as $tabela) {
            $nomeTabela = array_values((array)$tabela)[0];
            $nomeTabelaUC=ucfirst($nomeTabela);
            $atributos=$this->buscaAtributos($nomeTabela);
            $attr = "";
            $id="";
            foreach($atributos as $atributo){
                if($atributo->Key=="PRI")
                    $id="{\$dado['{$atributo->Field}']}";
                $attr.= "echo \"<td>{\$dado['{$atributo->Field}']}</td>\";\n";
            }

            $conteudo = <<<HTML
<html>
<head>
    <title>Lista de {$nomeTabela}</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<?php
require_once("../dao/{$nomeTabela}Dao.php");
\$dao=new {$nomeTabela}Dao();
\$dados=\$dao->listaGeral();
echo "<table border=1>";
foreach(\$dados as \$dado){
    echo "<tr>";
    {$attr}
    echo "<td><a href='../control/{$nomeTabela}Control.php?id={$id}&a=2'>Excluir</a></td>";
    echo "<td><a href='../view/{$nomeTabela}.php?id={$id}'>Alterar</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>
HTML;

            file_put_contents("sistema/view/lista{$nomeTabelaUC}.php", $conteudo);
        }
    }

    function ClasseHome(){
    $linksCadastros = "";
    $linksRelatorios = "";

    foreach ($this->tabelas as $tabela) {
        $nomeTabela = array_values((array)$tabela)[0];
        $nomeTabelaUC = ucfirst($nomeTabela);

        // Links para Cadastros
        $linksCadastros .= "<li><a href='view/{$nomeTabela}.php'>Cadastro de {$nomeTabelaUC}</a></li>\n";

        // Links para Relatórios (listas)
        $linksRelatorios .= "<li><a href='view/lista{$nomeTabelaUC}.php'>Relatório de {$nomeTabelaUC}</a></li>\n";
    }

    $conteudo = <<<HTML
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="sistema/css/estilos.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .cabecalho {
            width: 100%;
            height: 200px;
            background-color: #2c3e50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
        .menu {
            width: 100%;
            height: 100px;
            background-color: #34495e;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }
        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 40px;
        }
        .menu li {
            position: relative;
        }
        .menu a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px;
            display: block;
        }
        .menu li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #2c3e50;
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: 200px;
        }
        .menu li ul li a {
            padding: 10px;
            font-size: 16px;
        }
        .menu li:hover ul {
            display: block;
        }
        .conteudo {
            min-height: calc(100vh - 300px);
            padding: 20px;
            background-color: #ecf0f1;
        }
    </style>
</head>
<body>
    <div class="cabecalho">
       Sistema - {$this->banco}
    </div>


    <div class="menu">
        <ul>
            <li>
                <a href="#">Cadastros</a>
                <ul>
                    {$linksCadastros}
                </ul>
            </li>
            <li>
                <a href="#">Relatórios</a>
                <ul>
                    {$linksRelatorios}
                </ul>
            </li>
        </ul>
    </div>

    <div class="conteudo">
        <h2>Bem-vindo!</h2>
        <p>Esta é a área de conteúdo do sistema.</p>
    </div>
</body>
</html>
HTML;

    file_put_contents("sistema/index.php", $conteudo);
}


    function compactar() {
        $folderToZip = 'sistema';
        $outputZip = 'sistema.zip';
        $zip = new ZipArchive();
        if ($zip->open($outputZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }
        $folderPath = realpath($folderToZip);
        if (!is_dir($folderPath)) {
            return false;
        }
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        return $zip->close();
    }
}

new Creator();

