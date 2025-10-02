<?php
require_once("../model/empresas.php");
require_once("../dao/empresasDao.php");
class EmpresasControl {
    private $empresas;
    private $acao;
    private $dao;
    public function __construct(){
       $this->empresas=new Empresas();
       $this->dao=new EmpresasDao();
       $this->acao=$_GET["a"];
       $this->verificaAcao(); 
    }
    function verificaAcao(){
       switch($this->acao){
          case 1:
            $this->inserir();
            break;
          case 2:
            $this->excluir();
            break;
          case 3:
            $this->alterar();
            break;
       }
    }
    function inserir(){
        $this->empresas->setId($_POST['id']);
		$this->empresas->setNome($_POST['nome']);
		$this->empresas->setDescricao($_POST['descricao']);
		$this->empresas->setTelefone($_POST['telefone']);
		$this->empresas->setEmail($_POST['email']);
		$this->empresas->setId_tipo($_POST['id_tipo']);
		$this->empresas->setId_cidade($_POST['id_cidade']);
		
        $this->dao->inserir($this->empresas);
    }
    function excluir(){
        $this->dao->excluir($_REQUEST['id']);
    }
    function alterar(){
        $this->empresas->setId($_POST['id']);
		$this->empresas->setNome($_POST['nome']);
		$this->empresas->setDescricao($_POST['descricao']);
		$this->empresas->setTelefone($_POST['telefone']);
		$this->empresas->setEmail($_POST['email']);
		$this->empresas->setId_tipo($_POST['id_tipo']);
		$this->empresas->setId_cidade($_POST['id_cidade']);
		
        $id = $_POST['id'];
        $this->dao->alterar($this->empresas, $id);
    }
    function buscarId(Empresas $empresas){}
    function buscaTodos(){}
}
new EmpresasControl();
?>