<?php
class Professor {
	private $id;
	private $nome;
	private $disciplina;

	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getNome(){
		return $this->nome;
	}
	function setNome($nome){
		$this->nome=$nome;
	}
	function getDisciplina(){
		return $this->disciplina;
	}
	function setDisciplina($disciplina){
		$this->disciplina=$disciplina;
	}

}
?>