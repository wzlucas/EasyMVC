<?php
class Curso {
	private $id;
	private $nome;
	private $carga_horaria;

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
	function getCarga_horaria(){
		return $this->carga_horaria;
	}
	function setCarga_horaria($carga_horaria){
		$this->carga_horaria=$carga_horaria;
	}

}
?>