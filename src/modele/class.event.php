<?php
class Event{

 private $db;

 private $select;


 public function __construct($db){
 $this->db = $db;

 $this->select = $db->prepare("SELECT id,titre,information,illustration FROM event");


 }






  public function select(){
 $liste = $this->select->execute();
 if ($this->select->errorCode()!=0){
 print_r($this->select->errorInfo());
 }
 return $this->select->fetchAll();
 }

}
?>
