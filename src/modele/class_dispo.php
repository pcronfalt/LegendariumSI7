<?php

class Disponibilite {

    private $select;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from disponibilite d"); 
    }
    
    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
}
?>

