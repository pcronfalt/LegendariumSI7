<?php

class Editeur{
 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
 private $delete;
 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO editeur (nomediteur) VALUES (:nomediteur);");
 $this->update = $db->prepare("UPDATE  editeur  SET  nomediteur=:nomediteur WHERE idediteur=:id");
 $this->select = $db->prepare("SELECT idediteur,nomediteur FROM editeur");
 $this->selectById = $db->prepare("SELECT * FROM editeur WHERE idediteur=:id;");
 $this->delete = $db->prepare("DELETE FROM editeur WHERE idediteur=:id");
 }
 public function insert( $nomediteur){
 $r = true;
 $this->insert->execute(array(':nomediteur'=>$nomediteur));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($nomediteur,$idgenre){
     $r = true;
  $this->update->execute(array(':nomediteur'=>$nomediteur, ':id'=>$idgenre));
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
