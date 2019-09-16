<?php

class Disponibilite{
 private $db;
 private $insert;
 private $update;
 private $delete;
 private $select;
 private $selectById;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO disponibilite (libelledisponibilite) VALUES (:libelledisponibilite);");
 $this->update = $db->prepare("UPDATE  disponibilite  SET  libelledisponibilite=:libelledisponibilite WHERE iddisponibilite=:id");
 $this->delete = $db->prepare("DELETE FROM disponibilite WHERE iddisponibilite=:id");
 $this->select = $db->prepare("SELECT iddisponibilite,libelledisponibilite FROM disponibilite");
 $this->selectById = $db->prepare("SELECT * FROM disponibilite WHERE iddisponibilite=:id;");

 }
 public function insert($libelle){
 $r = true;
 $this->insert->execute(array(':libelledisponibilite'=>$libelle));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($libelledisponibilite,$iddisponibilite){
     $r = true;
  $this->update->execute(array(':libelledisponibilite'=>$libelledisponibilite, ':id'=>$iddisponibilite));
 if ($this->update->errorCode()!=0){
         print_r($this->update->errorInfo());
       $r=false;
     }
   return $r;
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

}
?>
