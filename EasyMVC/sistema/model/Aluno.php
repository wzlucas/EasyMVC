<?php
class Aluno {
	private $id;
	private $nome;
	private $idade;
	private $turma;

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
	function getIdade(){
		return $this->idade;
	}
	function setIdade($idade){
		$this->idade=$idade;
	}
	function getTurma(){
		return $this->turma;
	}
	function setTurma($turma){
		$this->turma=$turma;
	}

}
?>