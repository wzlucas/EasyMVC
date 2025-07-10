<?php
class Matricula {
	private $id;
	private $aluno_id;
	private $curso_id;
	private $ano_letivo;

	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getAluno_id(){
		return $this->aluno_id;
	}
	function setAluno_id($aluno_id){
		$this->aluno_id=$aluno_id;
	}
	function getCurso_id(){
		return $this->curso_id;
	}
	function setCurso_id($curso_id){
		$this->curso_id=$curso_id;
	}
	function getAno_letivo(){
		return $this->ano_letivo;
	}
	function setAno_letivo($ano_letivo){
		$this->ano_letivo=$ano_letivo;
	}

}
?>