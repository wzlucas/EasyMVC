<?php
require_once("../model/tipo_turismo.php");
require_once("../dao/tipo_turismoDao.php");
class Tipo_turismoControl {
    private $tipo_turismo;
    private $acao;
    private $dao;
    public function __construct(){
       $this->tipo_turismo=new Tipo_turismo();
       $this->dao=new Tipo_turismoDao();
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
        $this->tipo_turismo->setId($_POST['id']);
		$this->tipo_turismo->setNome($_POST['nome']);
		
        $this->dao->inserir($this->tipo_turismo);
    }
    function excluir(){
        $this->dao->excluir($_REQUEST['id']);
    }
    function alterar(){
        $this->tipo_turismo->setId($_POST['id']);
		$this->tipo_turismo->setNome($_POST['nome']);
		
        $id = $_POST['id'];
        $this->dao->alterar($this->tipo_turismo, $id);
    }
    function buscarId(Tipo_turismo $tipo_turismo){}
    function buscaTodos(){}
}
new Tipo_turismoControl();
?>