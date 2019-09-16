<?php

class Catalogue{
 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
 private $delete;
 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO collection (libellecollection) VALUES (:libellecollection);");
 $this->update = $db->prepare("UPDATE  collection  SET  libellecollection=:libellecollection WHERE idcollection=:idcollection");
 $this->select = $db->prepare("SELECT idcollection,libellecollection FROM collection");
 $this->selectById = $db->prepare("SELECT * FROM collection WHERE idcollection=:id;");
 $this->delete = $db->prepare("DELETE FROM collection WHERE idcollection=:id");
 }
 public function insert($libellecollection){
 $r = true;
 $this->insert->execute(array(':libellecollection'=>$libellecollection));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($libellecollection,$idcollection){
     $r = true;
  $this->update->execute(array(':libellecollection'=>$libellecollection, ':idcollection'=>$idcollection));
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
