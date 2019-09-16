<?php

class Editeur {

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
        $this->insert = $db->prepare("insert into editeur(libelleE) values (:libelleE)");
        $this->select = $db->prepare("select * from editeur e");
        $this->update = $db->prepare("update editeur set libelleE=:libelleE where idEditeur=:idEditeur");
        $this->selectById = $db->prepare("select * from editeur where idEditeur=:idEditeur");
        $this->delete = $db->prepare("delete from editeur where idEditeur=:idEditeur");
        $this->selectLimit = $db->prepare("select * from editeur e limit :inf, :limite");
        $this->selectCount =$db->prepare("select count(*) as nb from editeur");
    }

    public function insert($libelleE) { // Étape 3
        $t = true;
        $this->insert->execute(array(':libelleE' => $libelleE));
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

    public function update($idEditeur, $libelleE) {
        $r = true;
        $this->update->execute(array(':idEditeur' => $idEditeur,':libelleE' => $libelleE));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idEditeur) {
        $this->selectById->execute(array(':idEditeur' => $idEditeur));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idEditeur) {
        $r = true;
        $this->delete->execute(array(':idEditeur' => $idEditeur));
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


