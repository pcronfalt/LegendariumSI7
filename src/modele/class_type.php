<?php
class Type{

 private $db;
 private $insert;
 private $select;
 private $selectById;
 private $update;
 

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO type ( libelle) VALUES ( :libelle);");
 $this->select = $db->prepare("SELECT id, libelle FROM type ;");
 $this->selectById = $db->prepare("select id, libelle from type where id=:id");
 $this->update = $db->prepare("update  type  set  libelle=:libelle where id=:id");
  
 }

 public function insert( $inputLibelle){
 $r = true;

 $this->insert->execute(array(':libelle'=>$inputLibelle));
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
 
 public function selectById($id){
 $this->selectById->execute(array(':id'=>$id));
 if ($this->selectById->errorCode()!=0){
 print_r($this->selectById->errorInfo());
 }
 return $this->selectById->fetch();
 }
 
public function update($libelle,$id){
    $r = true;
 $this->update->execute(array(':libelle'=>$libelle, ':id'=>$id));
if ($this->update->errorCode()!=0){
        print_r($this->update->errorInfo());  
      $r=false;
    }
  return $r;
 }


}
?>
