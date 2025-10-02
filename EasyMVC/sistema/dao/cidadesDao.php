<?php
require_once("../model/conexao.php");
class CidadesDao {
    private $con;
    public function __construct(){
       $this->con = (new Conexao())->conectar();
    }
    function inserir($obj) {
        $sql = "INSERT INTO cidades (id, nome) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);
        $id = $obj->getId();
		$nome = $obj->getNome();
		
        $stmt->execute([$id,$nome]);
        header("Location:../view/listaCidades.php");
    exit;
    }
    function listaGeral(){
        $sql = "SELECT * FROM cidades";
        $query = $this->con->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscaPorId($id){
        $sql = "SELECT * FROM cidades WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function excluir($id){
        $sql = "DELETE FROM cidades WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        header("Location:../view/listaCidades.php");
    }
    function alterar($obj, $id){
        $sql = "UPDATE cidades SET nome = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $valores = [];
        $valores[] = $obj->getNome();
		
        $valores[] = $id;
        $stmt->execute($valores);

        header("Location:../view/listaCidades.php");
    exit;
    }
}
?>