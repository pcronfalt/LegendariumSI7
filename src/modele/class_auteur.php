<?php

class Auteur{
 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
 private $delete;
 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO auteur (nomauteur,prenomauteur,biographieauteur) VALUES (  :nomauteur,:prenomauteur,:biographieauteur);");
 $this->update = $db->prepare("UPDATE  auteur  SET  nomauteur=:nomauteur,prenomauteur=:prenomauteur,biographieauteur=:biographieauteur  WHERE idauteur=:id");
 $this->select = $db->prepare("SELECT idauteur,nomauteur,prenomauteur,biographieauteur FROM auteur");
 $this->selectById = $db->prepare("SELECT * FROM auteur WHERE idauteur=:id;");
 $this->delete = $db->prepare("DELETE FROM auteur WHERE idauteur=:id");
 }
 public function insert( $nomauteur,$prenomauteur,$biographieauteur){
 $r = true;
 $this->insert->execute(array(':nomauteur'=>$nomauteur,':prenomauteur'=>$prenomauteur,':biographieauteur'=>$biographieauteur));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }
 public function update($inputNom,$inputPrenom,$inputBiographie,$idauteur){
     $r = true;
  $this->update->execute(array(':nomauteur'=>$inputNom, ':prenomauteur'=>$inputPrenom, ':biographieauteur'=>$inputBiographie, ':id'=>$idauteur));
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
