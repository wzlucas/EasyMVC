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
       Sistema - db_empresas
    </div>


    <div class="menu">
        <ul>
            <li>
                <a href="#">Cadastros</a>
                <ul>
                    <li><a href='view/cidades.php'>Cadastro de Cidades</a></li>
<li><a href='view/empresas.php'>Cadastro de Empresas</a></li>
<li><a href='view/tipo_turismo.php'>Cadastro de Tipo_turismo</a></li>

                </ul>
            </li>
            <li>
                <a href="#">Relatórios</a>
                <ul>
                    <li><a href='view/listaCidades.php'>Relatório de Cidades</a></li>
<li><a href='view/listaEmpresas.php'>Relatório de Empresas</a></li>
<li><a href='view/listaTipo_turismo.php'>Relatório de Tipo_turismo</a></li>

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