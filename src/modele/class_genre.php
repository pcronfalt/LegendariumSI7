<?php

class Genre{
 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
private $delete;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO genre (libellegenre) VALUES (:libellegenre);");
 $this->update = $db->prepare("UPDATE  genre  SET  libellegenre=:libellegenre WHERE idgenre=:id");
 $this->select = $db->prepare("SELECT idgenre,libellegenre FROM genre");
 $this->selectById = $db->prepare("SELECT * FROM genre WHERE idgenre=:id;");
 $this->delete = $db->prepare("DELETE FROM genre WHERE idgenre=:id");
 }
 public function insert( $libellegenre ){
 $r = true;
 $this->insert->execute(array(':libellegenre'=>$libellegenre));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($libellegenre,$idgenre){
     $r = true;
  $this->update->execute(array(':libellegenre'=>$libellegenre, ':id'=>$idgenre));
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
