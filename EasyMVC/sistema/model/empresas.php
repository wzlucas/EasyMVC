<?php
class Empresas {
	private $id;
	private $nome;
	private $descricao;
	private $telefone;
	private $email;
	private $id_tipo;
	private $id_cidade;

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
	function getDescricao(){
		return $this->descricao;
	}
	function setDescricao($descricao){
		$this->descricao=$descricao;
	}
	function getTelefone(){
		return $this->telefone;
	}
	function setTelefone($telefone){
		$this->telefone=$telefone;
	}
	function getEmail(){
		return $this->email;
	}
	function setEmail($email){
		$this->email=$email;
	}
	function getId_tipo(){
		return $this->id_tipo;
	}
	function setId_tipo($id_tipo){
		$this->id_tipo=$id_tipo;
	}
	function getId_cidade(){
		return $this->id_cidade;
	}
	function setId_cidade($id_cidade){
		$this->id_cidade=$id_cidade;
	}

}
?>