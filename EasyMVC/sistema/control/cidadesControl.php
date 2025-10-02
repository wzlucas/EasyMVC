<?php
require_once("../model/cidades.php");
require_once("../dao/cidadesDao.php");
class CidadesControl {
    private $cidades;
    private $acao;
    private $dao;
    public function __construct(){
       $this->cidades=new Cidades();
       $this->dao=new CidadesDao();
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
        $this->cidades->setId($_POST['id']);
		$this->cidades->setNome($_POST['nome']);
		
        $this->dao->inserir($this->cidades);
    }
    function excluir(){
        $this->dao->excluir($_REQUEST['id']);
    }
    function alterar(){
        $this->cidades->setId($_POST['id']);
		$this->cidades->setNome($_POST['nome']);
		
        $id = $_POST['id'];
        $this->dao->alterar($this->cidades, $id);
    }
    function buscarId(Cidades $cidades){}
    function buscaTodos(){}
}
new CidadesControl();
?>