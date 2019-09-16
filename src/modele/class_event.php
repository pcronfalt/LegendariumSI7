<?php
class Event{

 private $db;
 private $insert;
 private $update;
 private $select;
 private $selectById;
 private $delete;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO event (titre,information,illustration) VALUES (  :titre,:information,:illustration);");
 $this->update = $db->prepare("UPDATE  event  SET  titre=:titre,information=:information,illustration=:illustration WHERE id=:id");
 $this->select = $db->prepare("SELECT id,titre,information,illustration FROM event");
 $this->selectById = $db->prepare("SELECT * FROM event WHERE id=:id;");
 $this->delete = $db->prepare("DELETE FROM event WHERE id=:id");

 }

 public function insert( $titre,$information,$illustration){
  $r = true;
  $this->insert->execute(array(':titre'=>$titre,':information'=>$information,':illustration'=>$illustration));
  if ($this->insert->errorCode()!=0){
  print_r($this->insert->errorInfo());
  $r=false;
  }
  return $r;
  }
  public function update($titre,$information,$illustration,$id){
       $r = true;
    $this->update->execute(array(':titre'=>$titre,':information'=>$information,':illustration'=>$illustration,':id'=>$id));
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
