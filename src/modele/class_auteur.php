<?php

class Auteur {

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
        $this->insert = $db->prepare("insert into auteur(prenomA, nomA, biographie) values (:prenom, :nom, :biographie)");
        $this->select = $db->prepare("select * from auteur a order by nomA");
        $this->update = $db->prepare("update auteur set nomA=:nom, prenomA=:prenom, biographie=:biographie where idAuteur=:idAuteur");
        $this->selectById = $db->prepare("select * from auteur where idAuteur=:idAuteur ");
        $this->delete = $db->prepare("delete from auteur where idAuteur=:idAuteur");
        $this->selectLimit = $db->prepare("select * from auteur a limit :inf, :limite");
        $this->selectCount =$db->prepare("select count(*) as nb from auteur");
    }

    public function insert($prenom, $nom, $biographie) { // Étape 3
        $t = true;
        $this->insert->execute(array(':prenom' => $prenom, ':nom' => $nom, ':biographie' => $biographie));
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

    public function update($idAuteur, $prenom, $nom, $biographie) {
        $r = true;
        $this->update->execute(array(':idAuteur' => $idAuteur,':prenom' => $prenom, ':nom' => $nom, ':biographie' => $biographie));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idAuteur) {
        $this->selectById->execute(array(':idAuteur' => $idAuteur));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idAuteur) {
        $r = true;
        $this->delete->execute(array(':idAuteur' => $idAuteur));
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