<?php

class Categorie {

    private $select;
    private $insert;
    private $db;
    private $update;
    private $selectById;
    private $delete;
    private $selectLimit;
    private $selectCount;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into categorie(libelleC) values (:libelleC)");
        $this->select = $db->prepare("select * from categorie c");
        $this->update = $db->prepare("update categorie set libelleC=:libelleC where idCat=:idCat");
        $this->selectById = $db->prepare("select * from categorie where idCat=:idCat ");
        $this->delete = $db->prepare("delete from categorie where idCat=:idCat");
        $this->selectLimit = $db->prepare("select * from categorie c limit :inf, :limite");
        $this->selectCount =$db->prepare("select count(*) as nb from categorie");
    }

    public function insert($libelleC) { // Étape 3
        $t = true;
        $this->insert->execute(array(':libelleC' => $libelleC));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function update($idCat, $libelleC) {
        $r = true;
        $this->update->execute(array(':idCat' => $idCat,':libelleC' => $libelleC));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idCat) {
        $this->selectById->execute(array(':idCat' => $idCat));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idCat) {
        $r = true;
        $this->delete->execute(array(':idCat' => $idCat));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
     public function selectLimit($inf, $limite) {        
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();        
        if ($this->selectLimit->errorCode()!=0){   
            print_r($this->selectLimit->errorInfo());         
        }        
        return $this->selectLimit->fetchAll(); 
    }
    public function selectCount() { 
        $this->selectCount->execute(); 
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo()); 
        }       
        return $this->selectCount->fetch();  
    }

}

?>


