<?php
require_once("../model/conexao.php");
class EmpresasDao {
    private $con;
    public function __construct(){
       $this->con = (new Conexao())->conectar();
    }
    function inserir($obj) {
        $sql = "INSERT INTO empresas (id, nome, descricao, telefone, email, id_tipo, id_cidade) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $id = $obj->getId();
		$nome = $obj->getNome();
		$descricao = $obj->getDescricao();
		$telefone = $obj->getTelefone();
		$email = $obj->getEmail();
		$id_tipo = $obj->getId_tipo();
		$id_cidade = $obj->getId_cidade();
		
        $stmt->execute([$id,$nome,$descricao,$telefone,$email,$id_tipo,$id_cidade]);
        header("Location:../view/listaEmpresas.php");
    exit;
    }
    function listaGeral(){
        $sql = "SELECT * FROM empresas";
        $query = $this->con->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscaPorId($id){
        $sql = "SELECT * FROM empresas WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function excluir($id){
        $sql = "DELETE FROM empresas WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        header("Location:../view/listaEmpresas.php");
    }
    function alterar($obj, $id){
        $sql = "UPDATE empresas SET nome = ?, descricao = ?, telefone = ?, email = ?, id_tipo = ?, id_cidade = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $valores = [];
        $valores[] = $obj->getNome();
		$valores[] = $obj->getDescricao();
		$valores[] = $obj->getTelefone();
		$valores[] = $obj->getEmail();
		$valores[] = $obj->getId_tipo();
		$valores[] = $obj->getId_cidade();
		
        $valores[] = $id;
        $stmt->execute($valores);

        header("Location:../view/listaEmpresas.php");
    exit;
    }
}
?>