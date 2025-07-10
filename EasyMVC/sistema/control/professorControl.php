<?php
require_once("../model/Professor.php");
require_once("../dao/ProfessorDao.php");
class ProfessorControl {
    private $professor;
    private $acao;
    private $dao;
    public function __construct(){
       $this->professor=new Professor();
      $this->dao=new ProfessorDao();
      $this->acao=$_GET["a"];
      $this->verificaAcao(); 
    }
    function verificaAcao(){}
    function inserir(){}
    function excluir(){}
    function alterar(){}
    function buscarId(Professor $professor){}
    function buscaTodos(){}

}
new ProfessorControl();
?>