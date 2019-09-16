<?php
class Produit{

 private $db;
 private $insert;
 private $select;
private $delete;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO produit ( designation, description, prix, idType ) VALUES ( :designation, :description, :prix, :idtype);");
 $this->select = $db->prepare("SELECT designation, description, prix, idType, libelle FROM produit p INNER JOIN type t ON p.idType = t.id ORDER BY designation;");
 $this->delete = $db->prepare("delete from produit where id=:id");

 }

 public function insert( $inputDesignation, $inputDescription, $inputPrix, $inputType){
 $r = true;

 $this->insert->execute(array(':designation'=>$inputDesignation  , ':description'=>$inputDescription, ':prix'=>$inputPrix, ':idtype'=>$inputType));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }



  public function select(){
 $liste = $this->select->execute();

 if ($this->select->errorCode()!=0){
 print_r($this->select->errorInfo());
 }
 return $this->select->fetchAll();
 }

 public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());
             $r=false;
        }
        return $r;
    }


}
?>
