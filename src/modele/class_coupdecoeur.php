<?php

class Coupdecoeur{
 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
 private $delete;
 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO coupdecoeur (libellecoupdecoeur) VALUES (:libellecoupdecoeur);");
 $this->update = $db->prepare("UPDATE  coupdecoeur  SET  libellecoupdecoeur=:libellecoupdecoeur WHERE idcoupdecoeur=:id");
 $this->select = $db->prepare("SELECT idcoupdecoeur,libellecoupdecoeur FROM coupdecoeur");
 $this->selectById = $db->prepare("SELECT * FROM coupdecoeur WHERE idcoupdecoeur=:id;");
 $this->delete = $db->prepare("DELETE FROM coupdecoeur WHERE idcoupdecoeur=:id");
 }
 public function insert( $libellecoupdecoeur){
 $r = true;
 $this->insert->execute(array(':libellecoupdecoeur'=>$libellecoupdecoeur));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($libellecoupdecoeur,$idcoupdecoeur){
     $r = true;
  $this->update->execute(array(':libellecoupdecoeur'=>$libellecoupdecoeur, ':id'=>$idcoupdecoeur));
 if ($this->update->errorCode()!=0){
         print_r($this->update->errorInfo());
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
 public function selectById($id){
 $this->selectById->execute(array(':id'=>$id));
 if ($this->selectById->errorCode()!=0){
 print_r($this->selectById->errorInfo());
 }
 return $this->selectById->fetch();
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
