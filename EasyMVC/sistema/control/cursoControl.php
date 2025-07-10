<?php
require_once("../model/Curso.php");
require_once("../dao/CursoDao.php");
class CursoControl {
    private $curso;
    private $acao;
    private $dao;
    public function __construct(){
       $this->curso=new Curso();
      $this->dao=new CursoDao();
      $this->acao=$_GET["a"];
      $this->verificaAcao(); 
    }
    function verificaAcao(){}
    function inserir(){}
    function excluir(){}
    function alterar(){}
    function buscarId(Curso $curso){}
    function buscaTodos(){}

}
new CursoControl();
?>