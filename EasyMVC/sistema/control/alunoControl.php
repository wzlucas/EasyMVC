<?php
require_once("../model/Aluno.php");
require_once("../dao/AlunoDao.php");
class AlunoControl {
    private $aluno;
    private $acao;
    private $dao;
    public function __construct(){
       $this->aluno=new Aluno();
      $this->dao=new AlunoDao();
      $this->acao=$_GET["a"];
      $this->verificaAcao(); 
    }
    function verificaAcao(){}
    function inserir(){}
    function excluir(){}
    function alterar(){}
    function buscarId(Aluno $aluno){}
    function buscaTodos(){}

}
new AlunoControl();
?>