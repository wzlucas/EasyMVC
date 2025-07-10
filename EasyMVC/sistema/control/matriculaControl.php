<?php
require_once("../model/Matricula.php");
require_once("../dao/MatriculaDao.php");
class MatriculaControl {
    private $matricula;
    private $acao;
    private $dao;
    public function __construct(){
       $this->matricula=new Matricula();
      $this->dao=new MatriculaDao();
      $this->acao=$_GET["a"];
      $this->verificaAcao(); 
    }
    function verificaAcao(){}
    function inserir(){}
    function excluir(){}
    function alterar(){}
    function buscarId(Matricula $matricula){}
    function buscaTodos(){}

}
new MatriculaControl();
?>